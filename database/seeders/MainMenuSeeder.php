<?php

namespace Database\Seeders;

use App\Models\Menu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $main = Menu::create(['title'  => ['ar' => 'الرئيسية', 'en' => 'Main'], 'icon'   => 'fa fa-home', 'link'  =>  'index', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);

        $about_instatute  = Menu::create(['title'  => ['ar' => 'عن الجامعة', 'en' => 'About University'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'التعريف بالجامعة', 'en' => 'Introduction to the University'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $about_instatute->id]);
        Menu::create(['title'  => ['ar' => 'الرؤية والاهداف', 'en' => 'Vision and goals'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $about_instatute->id]);

        $addmission_registeration  = Menu::create(['title'  => ['ar' => 'القبول والتسجيل', 'en' => 'Admission'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'دليل التسجيل', 'en' => 'Registration guide'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $addmission_registeration->id]);
        Menu::create(['title'  => ['ar' => 'متطلبات التسجيل', 'en' => 'Registration requirements'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $addmission_registeration->id]);

        $Scientific_specializations  = Menu::create(['title'  => ['ar' => 'التخصصات العملية', 'en' => 'specializations'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'فني صيدلة', 'en' => 'Pharmacy technician'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $Scientific_specializations->id]);
        Menu::create(['title'  => ['ar' => 'فني مختبرات طبية', 'en' => 'Medical laboratory technician'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $Scientific_specializations->id]);
        Menu::create(['title'  => ['ar' => 'مساعد طبي', 'en' => 'Medical assistant'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $Scientific_specializations->id]);
        Menu::create(['title'  => ['ar' => 'توليد وقبالة', 'en' => 'Generate and off'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $Scientific_specializations->id]);

        $Media_images  = Menu::create(['title'  => ['ar' => 'الوسائط والصور', 'en' => 'Media'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);

        $contact_us  = Menu::create(['title'  => ['ar' => 'تواصل معنا', 'en' => 'Contact Us'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
