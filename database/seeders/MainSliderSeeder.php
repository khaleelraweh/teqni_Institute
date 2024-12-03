<?php

namespace Database\Seeders;

use App\Models\Slider;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MainSliderSeeder extends Seeder
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

        $slider1 = Slider::create([
            'title'         => ['ar' => 'دورات عبر الإنترنت من كبار الخبراء', 'en' => 'Online Courses From Leading Experts'],
            'subtitle'         => ['ar' => 'البدء في التعلم اليوم', 'en' => 'Start to learning today'],
            'slug'          => ['ar' => $faker->unique()->slug(3), 'en' => $faker->unique()->slug(3)],
            'description'   => ['ar' => ' التكنولوجيا تجلب موجة ناجحة من التعلم في العديد من المناحي المختلفة ', 'en' => ' Technology Is Brining A Missave Wave Of Education On Learning Thinks On Different Ways '],

            'url'           => ['ar' => 'https://' . $faker->slug(2) . '.com', 'en' => 'https://' . $faker->slug(2) . '.com'],
            'btn_title'     => ['ar' => 'العثور على الدورات', 'en' => 'Find Courses'],
            'target'        =>  Arr::random($target),
            'published_on'  =>  $faker->dateTime(),
            'created_by'    =>  $faker->realTextBetween(10, 12),
            'updated_by'    =>  $faker->realTextBetween(10, 12),
            'deleted_at'    =>  null,
            'created_at'    =>  now(),
            'updated_at'    =>  now(),
        ]);

        $slider2 = Slider::create([
            'title'         => ['ar' => 'استكشف الاهتمامات والوظائف من خلال الدورات التدريبية', 'en' => 'Explore Interests and Career With Courses'],
            'subtitle'         => ['ar' => 'البدء في التعلم اليوم', 'en' => 'Start to learning today'],
            'slug'          => ['ar' => $faker->unique()->slug(3), 'en' => $faker->unique()->slug(3)],
            'description'   => ['ar' => ' التكنولوجيا تجلب موجة ناجحة من التعلم في العديد من المناحي المختلفة ', 'en' => ' Technology Is Brining A Missave Wave Of Education On Learning Thinks On Different Ways '],

            'url'           => ['ar' => 'https://' . $faker->slug(2) . '.com', 'en' => 'https://' . $faker->slug(2) . '.com'],
            'btn_title'         => ['ar' => 'العثور على الدورات', 'en' => 'Find Courses'],

            'target'        =>  Arr::random($target),
            'published_on'  =>  $faker->dateTime(),
            'created_by'    =>  $faker->realTextBetween(10, 12),
            'updated_by'   =>  $faker->realTextBetween(10, 12),
            'deleted_at'    =>  null,
            'created_at'    =>  now(),
            'updated_at'    =>  now(),
        ]);
    }
}
