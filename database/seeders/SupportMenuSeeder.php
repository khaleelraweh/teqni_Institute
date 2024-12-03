<?php

namespace Database\Seeders;

use App\Models\Menu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Menu::create(['title'  => ['ar' => 'وزارة التعليم العالي والبحث العلمي', 'en' => 'Ministry of Higher Education and Scientific Research'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  5, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'مجلس الاعتماد الأكاديمي وضمان الجودة', 'en' => 'Council for Academic Accreditation and Quality Assurance'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  5, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'مركز تقنية المعلومات في التعليم العالي', 'en' => 'Center for Information Technology in Higher Education'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  5, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'مدونة الجامعة', 'en' => 'University Blog'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  5, 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
