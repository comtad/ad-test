<?php

use Illuminate\Database\Seeder;

class DollsSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('ru_RU');

        $category = \App\Category::firstOrCreate(
            ['slug' => 'dolls'],
            ['name' => 'Куклы']
        );

        // >>> исправленный путь
        $base = database_path('picture/puppe');

        if (!is_dir($base)) {
            $this->command->warn("Директория не найдена: $base");
            return;
        }

        $rii = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
        );

        $created = 0;

        foreach ($rii as $fileInfo) {
            if (!$fileInfo->isFile()) continue;

            $ext = strtolower($fileInfo->getExtension());
            if (!in_array($ext, ['jpg','jpeg','png','webp','gif','bmp'])) continue;

            $filename  = $fileInfo->getBasename();
            $stem      = pathinfo($filename, PATHINFO_FILENAME);

            $year = null;
            if (preg_match('/(19\d{2}|20\d{2})/u', $stem, $m)) {
                $year = (int)$m[1];
            }

            $titleStem = preg_replace('~[_\-]+~u', ' ', $stem);
            $titleStem = trim(preg_replace('~\s+~u', ' ', $titleStem));
            $titleStem = mb_convert_case($titleStem, MB_CASE_TITLE, 'UTF-8');

            $title = $year
                ? "Кукла {$titleStem} ({$year})"
                : "Кукла {$titleStem}";

            $destRel = "products/dolls/{$filename}";
            $destAbs = public_path($destRel);
            @mkdir(dirname($destAbs), 0775, true);
            if (!is_file($destAbs)) {
                @copy($fileInfo->getPathname(), $destAbs);
            }

            $slug = \Str::slug("doll-{$stem}");

            $description = $faker->sentence().' '.$faker->paragraph();
            $price = $faker->numberBetween(500, 5000);

            \App\Product::firstOrCreate(
                ['slug' => $slug],
                [
                    'name'        => $title,
                    'category_id' => $category->id,
                    'price'       => $price,
                    'image'       => $destRel,
                    'description' => $description,
                ]
            );

            $created++;
        }

        $this->command->info("Dolls: создано/обновлено товаров: {$created}");
    }
}
