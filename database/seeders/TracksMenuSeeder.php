<?php

namespace Database\Seeders;

use App\Models\WebMenu;
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

        // WebMenu::create(['title'  => ['ar' => 'تصميم الويب', 'en' => 'Web Design'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        // WebMenu::create(['title'  => ['ar' => 'تطوير الويب', 'en' => 'Web Development'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        // WebMenu::create(['title'  => ['ar' => 'تطوير القضبان', 'en' => 'Rails Development'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        // WebMenu::create(['title'  => ['ar' => 'تطوير PHP', 'en' => 'PHP Development'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        // WebMenu::create(['title'  => ['ar' => 'تطوير اندرويد', 'en' => 'Android Development'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        // WebMenu::create(['title'  => ['ar' => 'بدء نشاط التجاري', 'en' => 'Starting a Business'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null]);

        WebMenu::create(['title'  => ['ar' => 'المدونة', 'en' => 'Blog'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null, 'link' => ['ar'  => 'blog-list', 'en' => 'blog-list']]);
        WebMenu::create(['title'  => ['ar' => 'كل الاخبار', 'en' => 'All News'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null, 'link' => ['ar'  => 'news-list', 'en' => 'news-list']]);
        WebMenu::create(['title'  => ['ar' => 'تواصل معنا', 'en' => 'Contact'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  4, 'published_on' => $faker->dateTime(), 'parent_id' => null, 'link' => ['ar'  => 'contact', 'en' => 'contact']]);
    }
}
