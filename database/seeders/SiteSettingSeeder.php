<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        // site infos
        SiteSetting::create(['key'    =>  'site_name',          'value' =>  ['ar' => 'جامة إب', 'en' => 'Ibb University'],       'status'    =>  true,       'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_short_name',    'value' =>  ['ar' => 'جامعة إب', 'en' => 'Ibb University'],           'status'    =>  true,       'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_address',   'value' =>  ['ar' => 'الجمهورية اليمنية', 'en' => 'Republic of Yemen'],   'status'    =>  true,   'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_description',   'value' =>  ['ar' => 'التعليم كما تحلم به', 'en' => 'Education as your dreams'],   'status'    =>  true,   'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_link',          'value' =>  'https://www.ibbuniv.edu.ye',                     'status'    =>  true,       'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_workTime',  'value' =>   ['ar' => 'طوال ايام الاسبوع', 'en' => 'Every Day In The Week'],   'status'    =>  true,   'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);

        SiteSetting::create(['key'    =>  'site_img',           'value' =>  '1.jpg',   'status'    =>  true,            'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);

        SiteSetting::create(['key'    =>  'site_logo_large_light',           'value' =>  '1.jpg',   'status'    =>  true,            'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_logo_small_light',           'value' =>  '1.jpg',   'status'    =>  true,            'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);

        SiteSetting::create(['key'    =>  'site_logo_large_dark',           'value' =>  '1.jpg',   'status'    =>  true,            'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_logo_small_dark',           'value' =>  '1.jpg',   'status'    =>  true,            'section'   =>  1,   'published_on'  =>  $faker->dateTime()]);

        // site contacts
        // SiteSetting::create(['key'    =>  'site_address',   'value' =>  ['ar' => 'الجمهورية اليمنية', 'en' => 'Republic of Yemen'],   'status'    =>  true,   'section'   =>  2,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_phone',     'value' =>  '772036131',                    'status'    =>  true,   'section'   =>  2,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_mobile',    'value' =>  '436285',                       'status'    =>  true,   'section'   =>  2,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_fax',       'value' =>  'fx',                           'status'    =>  true,   'section'   =>  2,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_po_box',    'value' =>  '985',                          'status'    =>  true,   'section'   =>  2,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_email1',    'value' =>  'https://www.ibbuniv.edu.ye',           'status'    =>  true,   'section'   =>  2,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_email2',    'value' =>  'https://www.ibbuniv.edu.ye',          'status'    =>  true,   'section'   =>  2,   'published_on'  =>  $faker->dateTime()]);
        // SiteSetting::create(['key'    =>  'site_workTime',  'value' =>   ['ar' => 'طوال ايام الاسبوع', 'en' => 'Every Day In The Week'],   'status'    =>  true,   'section'   =>  2,   'published_on'  =>  $faker->dateTime()]);

        // site socials
        SiteSetting::create(['key'    =>  'site_facebook',      'value' =>  'https://facebook.com',     'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_twitter',       'value' =>  'https://twitter.com',      'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_youtube',       'value' =>  'https://youtube.com',      'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_snapchat',      'value' =>  'https://snapchat.com',     'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_instagram',     'value' =>  'https://instagram.com',    'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_google',        'value' =>  'https://google.com',       'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_vimeo',         'value' =>  'https://vimeo.com',        'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_pinterest',     'value' =>  'https://pinterest.com',    'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_linkedin',      'value' =>  'https://linkedin.com',     'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_dribbble',      'value' =>  'https://dribbble.com',     'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_git_scm',      'value' =>  'https://git-scm.com',     'status'    =>  true,   'section'   =>  3,   'published_on'  =>  $faker->dateTime()]);

        // site seo
        SiteSetting::create(['key'    =>  'site_name_meta',         'value' =>  ['ar' => 'جامعة إب', 'en' => 'Ibb University'],   'status'    =>  true,   'section'   =>  4,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_description_meta',  'value' =>  ['ar' => 'واحدة من اعرق الجامعات في اليمن', 'en' => 'One of the most prestigious universities in Yemen'],   'status'    =>  true,   'section'   =>  4,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_link_meta',         'value' =>  'https://www.ibbuniv.edu.ye',   'status'    =>  true,   'section'   =>  4,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_keywords_meta',     'value' =>  ['ar' => ' ماجستير , بكلوريوس , جامعة', 'en' => 'University , Bachelor , Master'],   'status'    =>  true,   'section'   =>  4,   'published_on'  =>  $faker->dateTime()]);


        //site pay method 
        SiteSetting::create(['key'    =>  'site_pay_amazon',        'value' =>  ['ar' => 'امازون', 'en' => 'amazon'],   'status'    =>  true,   'section'   =>  5,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_pay_visa_card',     'value' =>  'visa-card',   'status'    =>  true,    'section'   =>  5,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_pay_skrill',        'value' =>  'skrill',   'status'    =>  true,       'section'   =>  5,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_pay_master_card',   'value' =>  'master-card',   'status'    =>  true,  'section'   =>  5,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_pay_paypal',        'value' =>  'paypal',   'status'    =>  true,       'section'   =>  5,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_pay_apple_pay',     'value' =>  'apple-pay',   'status'    =>  true,    'section'   =>  5,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_pay_klarna',        'value' =>  'klarna',   'status'    =>  true,       'section'   =>  5,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_pay_payoneer',      'value' =>  'payoneer',   'status'    =>  true,     'section'   =>  5,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_pay_bpay',          'value' =>  'bpay',   'status'    =>  true,         'section'   =>  5,   'published_on'  =>  $faker->dateTime()]);


        // site counters 
        SiteSetting::create(['key'    =>  'site_main_sliders',          'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_advertisor_sliders',    'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_card_categories',       'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_featured_cards',        'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_random_cards',          'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_related_cards',         'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]); // in card info page 
        SiteSetting::create(['key'    =>  'site_more_like_cards',       'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]); // in cart page 
        SiteSetting::create(['key'    =>  'site_posts',                 'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_questions',             'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]);
        SiteSetting::create(['key'    =>  'site_more_categories',       'value' =>  10,   'status'    =>  true,   'section'   =>  6,   'published_on'  =>  $faker->dateTime()]);
    }
}
