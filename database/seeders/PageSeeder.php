<?php

namespace Database\Seeders;

use App\Models\Page;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $page = Page::create([
            'title'                 => ['ar' => 'العنوان', 'en' => 'title'],
            'content'               => ['ar' => $faker->realText(50), 'en' => $faker->realText(50), 'ca' => $faker->realText(50)],

            'page_category_id'      => 1,

            'metadata_title'        => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_description'  => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
            'metadata_keywords'     => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],

            'status'                => true,
            'created_by'            => $faker->realTextBetween(10, 20),
            'updated_by'            => $faker->realTextBetween(10, 20), // Assuming you want this as well
        ]);
    }
}
