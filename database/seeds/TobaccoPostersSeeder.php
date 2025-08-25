<?php

use Illuminate\Database\Seeder;

class TobaccoPostersSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('ru_RU');

        $category = \App\Category::firstOrCreate(
            ['slug' => 'tobacco-posters'],
            ['name' => 'Рекламные плакаты табака']
        );

        $base = database_path('picture/tabaco');

        $publicBase = public_path('products');

        $brands = [
            'Marlboro'      => ['marlboro'],
            'Lucky Strike'  => ['lucky strike','lucky-strike','luckystrike'],
            'Chesterfield'  => ['chesterfield'],
            'Camel'         => ['camel'],
            'Pall Mall'     => ['pall mall','pall-mall','pallmall'],
            'Winston'       => ['winston'],
            'Kent'          => ['kent'],
            'Parliament'    => ['parliament'],
            'Philip Morris' => ['philip morris','philipmorris'],
            'Old Gold'      => ['old gold','oldgold'],
            'Raleigh'       => ['raleigh'],
            'Viceroy'       => ['viceroy'],
            'Kool'          => ['kool'],
            'Newport'       => ['newport'],
            'Salem'         => ['salem'],
        ];

        $normalize = function (string $s): string {
            $s = mb_strtolower($s, 'UTF-8');
            $s = preg_replace('~[^a-z0-9]+~iu', ' ', $s);
            return trim(preg_replace('~\s+~', ' ', $s));
        };

        if (!is_dir($base)) {
            $this->command->warn("Директория не найдена: $base");
            return;
        }
        if (!is_dir($publicBase)) {
            @mkdir($publicBase, 0775, true);
        }

        $created = 0;
        $currentYear = (int) date('Y');

        $rii = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
        );

        foreach ($rii as $fileInfo) {
            if (!$fileInfo->isFile()) continue;
            $ext = strtolower($fileInfo->getExtension());
            if (!in_array($ext, ['jpg','jpeg','png','webp','gif','bmp'])) continue;

            $filename  = $fileInfo->getBasename();
            $nameNoExt = pathinfo($filename, PATHINFO_FILENAME);
            $norm      = $normalize($nameNoExt);

            // бренд
            $brand = 'Lucky Strike';
            foreach ($brands as $brandName => $syns) {
                foreach ($syns as $syn) {
                    if (strpos($norm, $normalize($syn)) !== false) {
                        $brand = $brandName;
                        break 2;
                    }
                }
            }
            $brandDir = \Str::slug($brand);

            $year = 1955;
            if (preg_match('/(19\d{2}|20\d{2})/u', $nameNoExt, $m)) {
                $yy = (int) $m[1];
                $year = max(1900, min(1959, $yy));
            }

            $destDir = $publicBase . DIRECTORY_SEPARATOR . 'tobacco' . DIRECTORY_SEPARATOR . $brandDir;
            @mkdir($destDir, 0775, true);

            $destAbs = $destDir . DIRECTORY_SEPARATOR . $filename;
            if (is_file($destAbs)) {
                $stem = pathinfo($filename, PATHINFO_FILENAME);
                $i = 1;
                do {
                    $alt = $stem . '-' . $i . '.' . $ext;
                    $destAbs = $destDir . DIRECTORY_SEPARATOR . $alt;
                    $i++;
                } while (is_file($destAbs));
            }

            $imageRel = null;
            if (@copy($fileInfo->getPathname(), $destAbs)) {
                $imageRel = ltrim(str_replace(public_path(), '', $destAbs), DIRECTORY_SEPARATOR);
                $imageRel = str_replace(DIRECTORY_SEPARATOR, '/', $imageRel);
            }

            $title = "Плакат {$brand} {$year}";
            $slug  = \Str::slug("poster-{$brand}-{$year}-{$nameNoExt}");

            $age   = max(0, $currentYear - $year);
            $price = 300 + ($age * 10);
            $description = $faker->sentence().' '.$faker->paragraph();

            \App\Product::firstOrCreate(
                ['slug' => $slug],
                [
                    'name'        => $title,
                    'category_id' => $category->id,
                    'price'       => $price,
                    'image'       => $imageRel,
                    'description' => $description,
                ]
            );

            $created++;
        }

        $this->command->info("TobaccoPosters: создано/обновлено товаров: {$created}");
    }
}
