<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(SiteSettingSeeder::class);

        $this->call(EntrustSeeder::class);


        $this->call(TagSeeder::class);
        $this->call(PhotoSeeder::class);
        $this->call(SpecializationSeeder::class);

        $this->call(MainSliderSeeder::class);
        $this->call(AdvSliderSeeder::class);

        $this->call(MainMenuSeeder::class); // section 1
        $this->call(AcademicProgramMenuSeeder::class); //section 2
        $this->call(TopicsMenuSeeder::class); // section 3
        $this->call(TracksMenuSeeder::class); //section 4
        $this->call(SupportMenuSeeder::class); //section 5
        $this->call(CompanyMenuSeeder::class); // section 6
        $this->call(ImportantLinkMenuSeeder::class); // section 7
        $this->call(ContactUsMenuSeeder::class); // section 8
        $this->call(PoliciesPrivacyMenuSeeder::class); // section 9

        $this->call(PageCategorySeeder::class);
        $this->call(PageSeeder::class);

        $this->call(PostSeeder::class);
        $this->call(newsSeeder::class);
        $this->call(AdvsSeeder::class);
        $this->call(EventSeeder::class);

        $this->call(AlbumsSeeder::class);
        $this->call(PlaylistSeeder::class);

        $this->call(StatisticSeeder::class);

        $this->call(PresidentSpeechSeeder::class);
        $this->call(PartnerSeeder::class);
    }
}
