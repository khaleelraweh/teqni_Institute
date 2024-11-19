<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        // Get active instructor
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->active()->inRandomOrder()->take(10)->get();

        // Get active course categories


        // Loop through courses data
        $eventDatas = [
            [
                'title' => ['ar' => 'مؤتمر تصميم جديد لصندوق الضوء الأنيق من قطع الورق', 'en' => 'Elegant Light Box Paper Cut Dioramas New Design Conference'],
                'content'               => ['ar' => $faker->realText(50), 'en' => $faker->realText(50), 'ca' => $faker->realText(50)],
            ],
            [
                'title' => ['ar' => 'اكتشف القانون - التحق بأفضل كليات الحقوق في المملكة المتحدة', 'en' => 'Discover Law - Get into the best UK law schools'],
                'content'               => ['ar' => $faker->realText(50), 'en' => $faker->realText(50), 'ca' => $faker->realText(50)],
            ],
            [
                'title' => ['ar' => 'الأحداث المفتوحة للطلاب الجامعيين في جامعة كينجستون 2019-20', 'en' => 'Kingston College undergraduate Open Events 2019-20'],
                'content'               => ['ar' => $faker->realText(50), 'en' => $faker->realText(50), 'ca' => $faker->realText(50)],
            ],

        ];

        // Loop through each course data and create courses
        foreach ($eventDatas as $eventData) {
            $randomDays = mt_rand(1, 10);
            // Generate a start date within the current month and within the range of the next one to ten days
            $startDate = $faker->dateTimeBetween('now', "+$randomDays days");
            // Generate an end date within the same year, after the start date
            $endDate = $faker->dateTimeBetween($startDate->format('Y-m-d'), $startDate->format('Y-m-d') . ' +1 year');
            $startTime = $faker->time('H:i:s');
            $endTime = $faker->time('H:i:s');


            $event = Event::create([
                'title'                 => $eventData['title'],
                'content'               =>  $eventData['content'],

                'metadata_title'        => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
                'metadata_description'  => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],
                'metadata_keywords'     => ['ar' => $faker->realText(50), 'en' => $faker->realText(50)],

                'start_date' => $startDate,
                'end_date' => $endDate,

                'start_time' => $startTime,
                'end_time' => $endTime,


                'status' => true,
                'created_by' => $faker->realTextBetween(10, 20),
                'updated_by' => $faker->realTextBetween(10, 20), // Assuming you want this as well
            ]);

            // Shuffle the collection of users
            $shuffledUsers = $users->shuffle();

            // Take the first 3 users from the shuffled collection
            $selectedUsers = $shuffledUsers->take(3);

            // Attach users
            $event->users()->attach($selectedUsers->pluck('id')->toArray());
        }
    }
}
