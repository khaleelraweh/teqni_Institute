<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create(['name' => ['ar' => 'تطوير الذات', 'en' => 'Self development',], 'slug' => ['ar' => 'تطوير_الذات', 'en' => 'self_development'],  'section' => 1,  'status' => true]);
        Tag::create(['name' => ['ar' => 'تطوير البرمجيات', 'en' => 'software development',], 'slug' => ['ar' => 'تطوير_البرمجيات', 'en' => 'software_development'],  'section' => 1,  'status' => true]);

        Tag::create(['name' => ['ar' => 'تطوير الذات', 'en' => 'Self development',], 'slug' => ['ar' => 'تطوير_الذات', 'en' => 'self_development'],  'section' => 2,  'status' => true]);
        Tag::create(['name' => ['ar' => 'تطوير البرمجيات', 'en' => 'software development',], 'slug' => ['ar' => 'تطوير_البرمجيات', 'en' => 'software_development'],  'section' => 2,  'status' => true]);

        Tag::create(['name' => ['ar' => 'تطوير الذات', 'en' => 'Self development',], 'slug' => ['ar' => 'تطوير_الذات', 'en' => 'self_development'],  'section' => 3,  'status' => true]);
        Tag::create(['name' => ['ar' => 'تطوير البرمجيات', 'en' => 'software development',], 'slug' => ['ar' => 'تطوير_البرمجيات', 'en' => 'software_development'],  'section' => 3,  'status' => true]);
    }
}
