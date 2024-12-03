<?php

namespace Database\Seeders;

use App\Models\Menu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TracksMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Menu::create(['title'  => ['ar' => 'تصميم الويب', 'en' => 'Web Design'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'تطوير الويب', 'en' => 'Web Development'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'تطوير القضبان', 'en' => 'Rails Development'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'تطوير PHP', 'en' => 'PHP Development'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'تطوير اندرويد', 'en' => 'Android Development'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'بدء نشاط التجاري', 'en' => 'Starting a Business'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
