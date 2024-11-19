<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $Desiner = Specialization::create(['name' => ['ar' => 'مصمم', 'en'    =>  'Desiner']]);
        $Developer = Specialization::create(['name' => ['ar' => 'مبرمج', 'en'    =>  'Developer']]);
        $softEngineer = Specialization::create(['name' => ['ar' => 'مهندس برمجيات', 'en'    =>  'SoftWare Engineer']]);
    }
}
