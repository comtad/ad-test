<?php

use Illuminate\Database\Seeder;

class PlayboySeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('ru_RU');

        $category = \App\Category::firstOrCreate(
            ['slug' => 'playboy'],
            ['name' => 'Журнал Playboy']
        );

        $base = database_path('picture/playboy');

        if (!is_dir($base)) {
            $this->command->warn("Директория не найдена: $base");
            return;
        }

        $months = [
            '01' => 'Январь', '02' => 'Февраль', '03' => 'Март',
            '04' => 'Апрель', '05' => 'Май',     '06' => 'Июнь',
            '07' => 'Июль',   '08' => 'Август',  '09' => 'Сентябрь',
            '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь',
        ];

        $rii = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
        );

        $created = 0;
        $currentYear = (int)date('Y');

        foreach ($rii as $fileInfo) {
            if (!$fileInfo->isFile()) continue;

            $ext = strtolower($fileInfo->getExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) continue;

            $filename = $fileInfo->getBasename();
            if (!preg_match('/(?P<y>\d{4})-(?P<m>\d{2})/u', $filename, $m)) {
                continue;
            }

            $year  = (int)$m['y'];
            $month = $m['m'];
            $monthRu = $months[$month] ?? $month;

            $name = "Playboy {$monthRu} {$year}";

            $destRel = "products/playboy/{$year}/{$filename}";
            $destAbs = public_path($destRel);

            @mkdir(dirname($destAbs), 0775, true);
            if (!is_file($destAbs)) {
                @copy($fileInfo->getPathname(), $destAbs);
            }

            $slugBase = "playboy-{$year}-{$month}";
            $baseNoExt = pathinfo($filename, PATHINFO_FILENAME);
            if (preg_match('/\((.*?)\)/u', $baseNoExt)) {
                $slugBase .= '-'.\Str::slug($baseNoExt);
            }

            $age   = max(0, $currentYear - $year);
            $price = 500 + ($age * 50);

            $description = $faker->paragraphs(rand(2, 4), true);

            \App\Product::firstOrCreate(
                ['slug' => $slugBase],
                [
                    'name'        => $name,
                    'category_id' => $category->id,
                    'price'       => $price,
                    'image'       => $destRel,
                    'description' => $description,
                ]
            );

            $created++;
        }

        $this->command->info("Playboy: создано/обновлено товаров: {$created}");
    }
}
