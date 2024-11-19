<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $Statistic1 = Statistic::create([
            'title'             => ['ar' => 'الكليات والمعاهد', 'en' => 'Colleges and institutes'],
            'slug'              => ['ar' => $faker->unique()->slug(3), 'en' => $faker->unique()->slug(3)],
            'statistic_number'  => rand(50, 200),
            'icon'              => 'fas fa-code',

            'metadata_title'        => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_description'  => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_keywords'     => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],

            'created_by'    =>  $faker->realTextBetween(10, 12),
            'updated_by'    =>  $faker->realTextBetween(10, 12),
            'deleted_at'    =>  null,
            'created_at'    =>  now(),
            'updated_at'    =>  now(),
        ]);

        $Statistic2 = Statistic::create([
            'title'             => ['ar' => 'البرامج الأكاديمية', 'en' => 'Academic programs'],
            'slug'              => ['ar' => $faker->unique()->slug(3), 'en' => $faker->unique()->slug(3)],
            'statistic_number'  => rand(50, 200),
            'icon'              => 'fas fa-code',

            'metadata_title'        => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_description'  => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_keywords'     => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],

            'created_by'    =>  $faker->realTextBetween(10, 12),
            'updated_by'    =>  $faker->realTextBetween(10, 12),
            'deleted_at'    =>  null,
            'created_at'    =>  now(),
            'updated_at'    =>  now(),
        ]);

        $Statistic3 = Statistic::create([
            'title'             => ['ar' => 'طالب', 'en' => 'Students'],
            'slug'              => ['ar' => $faker->unique()->slug(3), 'en' => $faker->unique()->slug(3)],
            'statistic_number'  => rand(50, 200),
            'icon'              => 'fas fa-code',

            'metadata_title'        => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_description'  => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_keywords'     => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],

            'created_by'    =>  $faker->realTextBetween(10, 12),
            'updated_by'    =>  $faker->realTextBetween(10, 12),
            'deleted_at'    =>  null,
            'created_at'    =>  now(),
            'updated_at'    =>  now(),
        ]);

        $Statistic4 = Statistic::create([
            'title'             => ['ar' => 'أعضاء هيئة التدريس', 'en' => 'Faculty members'],
            'slug'              => ['ar' => $faker->unique()->slug(3), 'en' => $faker->unique()->slug(3)],
            'statistic_number'  => rand(50, 200),
            'icon'              => 'fas fa-code',

            'metadata_title'        => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_description'  => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_keywords'     => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],

            'created_by'    =>  $faker->realTextBetween(10, 12),
            'updated_by'    =>  $faker->realTextBetween(10, 12),
            'deleted_at'    =>  null,
            'created_at'    =>  now(),
            'updated_at'    =>  now(),
        ]);
    }
}
