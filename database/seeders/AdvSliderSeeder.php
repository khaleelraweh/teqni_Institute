<?php

namespace Database\Seeders;

use App\Models\Slider;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class AdvSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $target = ['_self', '_blank'];


        Slider::create(['title'  => ['ar' => 'الدورات عبر الإنترنت 100,000', 'en' => 'online courses 100,000 '], 'subtitle'  => ['ar' => 'الدورات عبر الإنترنت 100,000', 'en' => 'online courses 100,000 '], 'description' => ['ar' => 'استكشاف مجموعة متنوعة من المواضيع الجديدة', 'en' => 'Explore a variety of fresh topics'],  'btn_title'     => ['ar' => 'العثور على الدورات', 'en' => 'Find Courses'], 'url'  =>  'https://' . $faker->slug(2) . '.com', 'target' =>  Arr::random($target),   'icon'   => 'fas fa-code', 'section' => 2, 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime()]);
        Slider::create(['title'  => ['ar' => 'تعليمات الخبراء', 'en' => 'Expert instruction '], 'subtitle'  => ['ar' => 'الدورات عبر الإنترنت 100,000', 'en' => 'online courses 100,000 '], 'description' => ['ar' => 'ابحث عن المدرب المناسب لك', 'en' => 'Find the right instructor for you'], 'btn_title'     => ['ar' => 'العثور على الدورات', 'en' => 'Find Courses'], 'url'  =>  'https://' . $faker->slug(2) . '.com', 'target' =>  Arr::random($target),   'icon'   => 'fas fa-laptop-code', 'section' => 2, 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime()]);
        Slider::create(['title'  => ['ar' => 'الوصول مدى الحياة', 'en' => 'Lifetime access'], 'subtitle'  => ['ar' => 'الدورات عبر الإنترنت 100,000', 'en' => 'online courses 100,000 '], 'description' => ['ar' => 'تعلم في الجدول الزمني الخاص بك', 'en' => 'Learn on your schedule '], 'btn_title'     => ['ar' => 'العثور على الدورات', 'en' => 'Find Courses'], 'url'  =>  'https://' . $faker->slug(2) . '.com', 'target' =>  Arr::random($target),   'icon'   => 'fas fa-chalkboard-teacher', 'section' => 2, 'created_by' => 'admin', 'status' => true, 'published_on' => $faker->dateTime()]);
    }
}
