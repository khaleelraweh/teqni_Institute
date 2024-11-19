<?php

namespace Database\Seeders;

use App\Models\PageCategory;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $page = PageCategory::create([
            'title' => ['ar' => 'العنوان', 'en' => 'title'],
            'content' => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],

            'metadata_title' => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_description' => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_keywords' => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],

            'status' => true,
            'created_by' => $faker->realTextBetween(10, 20),
            'updated_by' => $faker->realTextBetween(10, 20), // Assuming you want this as well
        ]);
    }
}
