<?php

namespace Database\Seeders;

use App\Models\WebMenu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicsMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        WebMenu::create(['title'  => ['ar' => 'الاحداث القادمة', 'en' => 'Event'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'المدونة', 'en' => 'Blog'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'تواصل معنا', 'en' => 'Contact'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  3, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
