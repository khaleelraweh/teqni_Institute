<?php

namespace Database\Seeders;

use App\Models\PresidentSpeech;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresidentSpeechSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $presidentspeech = PresidentSpeech::create(['title' => ['ar' => 'عن المعهد', 'en'    =>  'About Insatatue'], 'content' => ['ar' => ' في سبعينيات القرن الماضي كان اليمن يعاني من نقص شديد في اعداد الكوادر الصحية المؤهلة في مجالات
        التمريض والقبالة وغيرها من التخصصات الصحية، وكانت المشكلة أكثر حدة في المحافظات النائية والمناطق
        الريفية والتي يعيش فيها أكثر من 75% من السكان، وفي عام 1971م تم تأسيس المعهد العالي للعلوم
        الصحية كمؤسسة تعليم صحي تقني حكومي في قلب العاصمة صنعاء بالشراكة والتعاون مع منظمة الصحة
        العالمية .', 'en' => 'In the 1970s, Yemen suffered from a severe shortage of qualified health personnel in the following areas
        Nursing, midwifery and other health specialties, and the problem was more severe in remote governorates and regions
        Rural areas, where more than 75% of the population lives. In 1971, the Higher Institute of Science was established
        Health is a governmental technical health education institution in the heart of the capital, Sana’a, in partnership and cooperation with the Health Organization
        Global.']]);
    }
}
