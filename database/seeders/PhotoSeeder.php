<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images[] = ['file_name' => '1.webp', 'file_type' => 'images/webp', 'file_size' => rand(100, 900), 'file_status' => true];
        $images[] = ['file_name' => '2.webp', 'file_type' => 'images/webp', 'file_size' => rand(100, 900), 'file_status' => true];
        $images[] = ['file_name' => '3.webp', 'file_type' => 'images/webp', 'file_size' => rand(100, 900), 'file_status' => true];
        $images[] = ['file_name' => '4.webp', 'file_type' => 'images/webp', 'file_size' => rand(100, 900), 'file_status' => true];
        $images[] = ['file_name' => '5.webp', 'file_type' => 'images/webp', 'file_size' => rand(100, 900), 'file_status' => true];
        $images[] = ['file_name' => '6.webp', 'file_type' => 'images/webp', 'file_size' => rand(100, 900), 'file_status' => true];
        $images[] = ['file_name' => '7.webp', 'file_type' => 'images/webp', 'file_size' => rand(100, 900), 'file_status' => true];
        $images[] = ['file_name' => '8.webp', 'file_type' => 'images/webp', 'file_size' => rand(100, 900), 'file_status' => true];




        //slider photo faker 
        Slider::all()->each(function ($slider) use ($images) {
            $slider->photos()->createMany(Arr::random($images, rand(1, 1)));
        });
    }
}
