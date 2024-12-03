<?php

namespace Database\Seeders;

use App\Models\Menu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Menu::create(['title'  => ['ar' => 'الرئيسية', 'en' => 'Our Company'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  6, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'من نحن', 'en' => 'About Us'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  6, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'تواصل معنا', 'en' => 'Contact Us'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  6, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'المجتمع', 'en' => 'Community'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  6, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'امتيازات الطلاب', 'en' => 'Student Perks'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  6, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'المدونة', 'en' => 'Blog'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  6, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'وظائف', 'en' => 'Careers'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  6, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
