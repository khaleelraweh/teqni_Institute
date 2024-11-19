<?php

namespace Database\Seeders;

use App\Models\WebMenu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $main = WebMenu::create(['title'  => ['ar' => 'الرئيسية', 'en' => 'Main'], 'icon'   => 'fa fa-home', 'link'  =>  'index', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);

        $about_instatute  = WebMenu::create(['title'  => ['ar' => 'عن المعهد', 'en' => 'About University'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'التعريف المعهد', 'en' => 'Introduction to the University'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $about_instatute->id]);
        WebMenu::create(['title'  => ['ar' => 'الرؤية والاهداف', 'en' => 'Vision and goals'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $about_instatute->id]);

        $addmission_registeration  = WebMenu::create(['title'  => ['ar' => 'القبول والتسجيل', 'en' => 'Admission'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'دليل التسجيل', 'en' => 'Registration guide'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $addmission_registeration->id]);
        WebMenu::create(['title'  => ['ar' => 'متطلبات التسجيل', 'en' => 'Registration requirements'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $addmission_registeration->id]);

        $Scientific_specializations  = WebMenu::create(['title'  => ['ar' => 'التخصصات العملية', 'en' => 'specializations'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        WebMenu::create(['title'  => ['ar' => 'فني صيدلة', 'en' => 'Pharmacy technician'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $Scientific_specializations->id]);
        WebMenu::create(['title'  => ['ar' => 'فني مختبرات طبية', 'en' => 'Medical laboratory technician'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $Scientific_specializations->id]);
        WebMenu::create(['title'  => ['ar' => 'مساعد طبي', 'en' => 'Medical assistant'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $Scientific_specializations->id]);
        WebMenu::create(['title'  => ['ar' => 'توليد وقبالة', 'en' => 'Generate and off'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => $Scientific_specializations->id]);

        $Media_images  = WebMenu::create(['title'  => ['ar' => 'الوسائط والصور', 'en' => 'Media'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);

        $contact_us  = WebMenu::create(['title'  => ['ar' => 'تواصل معنا', 'en' => 'Contact Us'], 'icon'   => 'fa fa-home', 'link' =>  ['ar' =>    'courses-list/تصميم', 'en'  =>    'courses-list/design'], 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
