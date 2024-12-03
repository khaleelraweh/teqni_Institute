<?php

namespace Database\Seeders;

use App\Models\Menu;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicProgramMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Menu::create(['title'  => ['ar' => 'طب الاسنان', 'en' => 'Dentistry'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  2, 'description'    =>  ['ar' => 'تُعد كلية الصيدلة أول كلية صحية في جامعة إب ، ومنذ نشأتها أخذت الكلية على عاتقها مهمة تخريج صيدلانيات مؤهلات وقادرات على المنافسة محلياً وعالمياً وفقاً لأعلى المعايير العلمية والمهنية. وتماشياً مع رؤية الجامعة، تسعى كلية الصيدلة لتقديم برامج أكاديمية معتمدة بهدف رفع جودة مخرجات', 'en'   =>  'The College of Pharmacy is the first health college at Ibb University, and since its inception, the college has undertaken the task of graduating qualified pharmacists who are able to compete locally and globally in accordance with the highest scientific and professional standards. In line with the university’s vision, the College of Pharmacy seeks to provide accredited academic programs with the aim of raising the quality of outcomes'], 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'الهندسة', 'en' => 'Engineering'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  2, 'description' =>  ['ar' => 'تُعد كلية الصيدلة أول كلية صحية في جامعة إب ، ومنذ نشأتها أخذت الكلية على عاتقها مهمة تخريج صيدلانيات مؤهلات وقادرات على المنافسة محلياً وعالمياً وفقاً لأعلى المعايير العلمية والمهنية. وتماشياً مع رؤية الجامعة، تسعى كلية الصيدلة لتقديم برامج أكاديمية معتمدة بهدف رفع جودة مخرجات', 'en'   =>  'The College of Pharmacy is the first health college at Ibb University, and since its inception, the college has undertaken the task of graduating qualified pharmacists who are able to compete locally and globally in accordance with the highest scientific and professional standards. In line with the university’s vision, the College of Pharmacy seeks to provide accredited academic programs with the aim of raising the quality of outcomes'], 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'القانون', 'en' => 'Law'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  2, 'description' =>  ['ar' => 'تُعد كلية الصيدلة أول كلية صحية في جامعة إب ، ومنذ نشأتها أخذت الكلية على عاتقها مهمة تخريج صيدلانيات مؤهلات وقادرات على المنافسة محلياً وعالمياً وفقاً لأعلى المعايير العلمية والمهنية. وتماشياً مع رؤية الجامعة، تسعى كلية الصيدلة لتقديم برامج أكاديمية معتمدة بهدف رفع جودة مخرجات', 'en'   =>  'The College of Pharmacy is the first health college at Ibb University, and since its inception, the college has undertaken the task of graduating qualified pharmacists who are able to compete locally and globally in accordance with the highest scientific and professional standards. In line with the university’s vision, the College of Pharmacy seeks to provide accredited academic programs with the aim of raising the quality of outcomes'], 'published_on' => $faker->dateTime(), 'parent_id' => null]);
        Menu::create(['title'  => ['ar' => 'عمادة الدراسات العليا', 'en' => 'Deanships of graduate studies'], 'icon'   => 'fa fa-home', 'created_by' => 'admin', 'status' => true, 'section'    =>  2, 'description' =>  ['ar' => 'تُعد كلية الصيدلة أول كلية صحية في جامعة إب ، ومنذ نشأتها أخذت الكلية على عاتقها مهمة تخريج صيدلانيات مؤهلات وقادرات على المنافسة محلياً وعالمياً وفقاً لأعلى المعايير العلمية والمهنية. وتماشياً مع رؤية الجامعة، تسعى كلية الصيدلة لتقديم برامج أكاديمية معتمدة بهدف رفع جودة مخرجات', 'en'   =>  'The College of Pharmacy is the first health college at Ibb University, and since its inception, the college has undertaken the task of graduating qualified pharmacists who are able to compete locally and globally in accordance with the highest scientific and professional standards. In line with the university’s vision, the College of Pharmacy seeks to provide accredited academic programs with the aim of raising the quality of outcomes'], 'published_on' => $faker->dateTime(), 'parent_id' => null]);
    }
}
