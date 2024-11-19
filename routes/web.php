<?php

use App\Http\Controllers\AdvertisorSliderController;
use App\Http\Controllers\Backend\AdvsController;
use App\Http\Controllers\Backend\AlbumsController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CollegeMenuController;
use App\Http\Controllers\Backend\CommonQuestionController;
use App\Http\Controllers\Backend\CommonQuestionVideoController;
use App\Http\Controllers\Backend\CompanyMenuController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DocumentArchivesController;
use App\Http\Controllers\Backend\EventsController;
use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\MainSliderController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\PageCategoriesController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PartnerController;
use App\Http\Controllers\Backend\PlaylistsController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\PresidentSpeechController;
use App\Http\Controllers\Backend\SiteSettingsController;
use App\Http\Controllers\Backend\SpecializationController;
use App\Http\Controllers\Backend\StatisticsController;
use App\Http\Controllers\Backend\SupervisorController;
use App\Http\Controllers\Backend\SupportMenuController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\TopicsMenuController;
use App\Http\Controllers\Backend\TracksMenuController;
use App\Http\Controllers\Backend\WebMenuController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);
// لايقاف الديباجر نضيف هذا الكود
app('debugbar')->disable();

//Frontend 
Route::get('/',         [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/index',    [FrontendController::class, 'index'])->name('frontend.index');

Route::get('/pages/{slug}', [FrontendController::class, 'pages'])->name('frontend.pages');

Route::get('/blog-list/{blog?}', [FrontendController::class, 'blog_list'])->name('frontend.blog_list');
Route::get('/news-list/{blog?}', [FrontendController::class, 'blog_list'])->name('frontend.news_list');
Route::get('/events-list/{blog?}', [FrontendController::class, 'blog_list'])->name('frontend.events_list');

Route::get('/blog-tag-list/{slug?}', [FrontendController::class, 'blog_tag_list'])->name('frontend.blog_tag_list');
Route::get('/news-tag-list/{slug?}', [FrontendController::class, 'blog_tag_list'])->name('frontend.news_tag_list');
Route::get('/events-tag-list/{slug?}', [FrontendController::class, 'blog_tag_list'])->name('frontend.events_tag_list');

Route::get('/blog-single/{blog?}', [FrontendController::class, 'blog_single'])->name('frontend.blog_single'); //section 1
Route::get('/news-single/{blog?}', [FrontendController::class, 'blog_single'])->name('frontend.news_single'); //section 2
Route::get('/event-single/{blog?}', [FrontendController::class, 'blog_single'])->name('frontend.event_single'); //section 3

Route::get('/album-list', [FrontendController::class, 'album_list'])->name('frontend.album_list');
Route::get('/album-single/{album?}', [FrontendController::class, 'album_single'])->name('frontend.album_single');

// Route::get('/album', [FrontendController::class, 'album'])->name('frontend.album');

Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');



Route::get('/change-language/{locale}',     [LocaleController::class, 'switch'])->name('change.language');


Route::get('/download-pdf/{filename}', function ($filename) {
    $pathToFile = public_path('assets/document_archives/' . $filename);

    if (!file_exists($pathToFile)) {
        abort(404, 'File not found');
    }

    // Customize the download name
    $downloadName = 'custom_' . $filename;

    return response()->download($pathToFile, $downloadName);
});




//Backend
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    //guest to website 
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [BackendController::class, 'login'])->name('login');
        Route::get('/register', [BackendController::class, 'register'])->name('register');
        Route::get('/lock-screen', [BackendController::class, 'lock_screen'])->name('lock-screen');
        Route::get('/recover-password', [BackendController::class, 'recover_password'])->name('recover-password');
    });

    //uthenticate to website 
    Route::group(['middleware' => ['roles', 'role:admin|supervisor']], function () {
        Route::get('/', [BackendController::class, 'index'])->name('index2');
        Route::get('/index', [BackendController::class, 'index'])->name('index');




        // ==============   Sliders Tab   ==============  //
        Route::post('main_sliders/remove-image', [MainSliderController::class, 'remove_image'])->name('main_sliders.remove_image');
        Route::resource('main_sliders', MainSliderController::class);

        Route::post('advertisor_sliders/remove-image', [AdvertisorSliderController::class, 'remove_image'])->name('advertisor_sliders.remove_image');
        Route::resource('advertisor_sliders', AdvertisorSliderController::class);

        // ================== Partners ================// 
        Route::post('partners/remove-image', [PartnerController::class, 'remove_image'])->name('partners.remove_image');
        Route::resource('partners', PartnerController::class);

        //=============== common question =========================//
        Route::resource('common_questions', CommonQuestionController::class);
        Route::post('common_question_videos/remove-image', [CommonQuestionVideoController::class, 'remove_image'])->name('common_question_videos.remove_image');
        Route::resource('common_question_videos', CommonQuestionVideoController::class);

        Route::post('testimonials/remove-image', [TestimonialController::class, 'remove_image'])->name('testimonials.remove_image');
        Route::resource('testimonials', TestimonialController::class);

        // ==============   Pages Tab   ==============  //
        Route::post('president_speeches/remove-image', [PresidentSpeechController::class, 'remove_image'])->name('president_speeches.remove_image');
        Route::resource('president_speeches', PresidentSpeechController::class);

        // ==============   Users Tab   ==============  //
        Route::post('customers/remove-image', [CustomerController::class, 'remove_image'])->name('customers.remove_image');
        Route::get('customers/get_customers', [CustomerController::class, 'get_customers'])->name('customers.get_customers');
        Route::resource('customers', CustomerController::class);

        Route::post('supervisors/remove-image', [SupervisorController::class, 'remove_image'])->name('supervisors.remove_image');
        Route::resource('supervisors', SupervisorController::class);

        Route::post('instructor/remove-image', [InstructorController::class, 'remove_image'])->name('instructors.remove_image');
        Route::resource('instructors', InstructorController::class);

        Route::resource('specializations', SpecializationController::class);

        Route::resource('tags', TagController::class);


        // ==============   Menus Tab   ==============  //
        Route::resource('web_menus', WebMenuController::class);
        Route::post('college-menus/remove-image', [CollegeMenuController::class, 'remove_image'])->name('college_menus.remove_image');
        Route::resource('college_menus', CollegeMenuController::class);
        Route::resource('company_menus', CompanyMenuController::class);
        Route::resource('topics_menus', TopicsMenuController::class);
        Route::resource('tracks_menus', TracksMenuController::class);
        Route::resource('support_menus', SupportMenuController::class);

        // ==============   Page Categories Tab   ==============  //
        Route::post('page-categories/remove-image', [PageCategoriesController::class, 'remove_image'])->name('page_categories.remove_image');
        Route::resource('page_categories', PageCategoriesController::class);


        // ==============   Pages Tab   ==============  //
        Route::post('pages/remove-image', [PagesController::class, 'remove_image'])->name('pages.remove_image');
        Route::resource('pages', PagesController::class);


        // ==============   Blog/Posts Tab   ==============  //
        Route::post('posts/remove-image', [PostController::class, 'remove_image'])->name('posts.remove_image');
        Route::resource('posts', PostController::class);


        // ==============   News Tab   ==============  //
        Route::post('news/remove-image', [NewsController::class, 'remove_image'])->name('news.remove_image');
        Route::resource('news', NewsController::class);

        // ==============   advs Tab   ==============  //
        Route::post('advs/remove-image', [AdvsController::class, 'remove_image'])->name('advs.remove_image');
        Route::resource('advs', AdvsController::class);


        // ==============   events Tab   ==============  //
        Route::post('events/remove-image', [EventsController::class, 'remove_image'])->name('events.remove_image');
        Route::resource('events', EventsController::class);


        // ==============   albums Tab   ==============  //
        Route::post('albums/remove-album-image', [AlbumsController::class, 'remove_album_image'])->name('albums.remove_album_image');
        Route::post('albums/remove-image', [AlbumsController::class, 'remove_image'])->name('albums.remove_image');
        Route::resource('albums', AlbumsController::class);


        // ==============   playlists Tab   ==============  //
        Route::post('playlists/remove-image', [PlaylistsController::class, 'remove_image'])->name('playlists.remove_image');
        Route::resource('playlists', PlaylistsController::class);



        // ==============   Document Archive Tab   ==============  //
        Route::resource('document_archives', DocumentArchivesController::class);

        // ==============   Statistics Tab   ==============  //
        Route::post('statistics/remove-statistic-image', [StatisticsController::class, 'remove_statistic_image'])->name('statistics.remove_statistic_image');
        Route::resource('statistics', StatisticsController::class);

        // ==============   Site Setting  Tab   ==============  //
        Route::get('site_setting/site_infos', [SiteSettingsController::class, 'show_main_informations'])->name('settings.site_main_infos.show');
        Route::post('site_setting/update_site_info/{id?}', [SiteSettingsController::class, 'update_main_informations'])->name('settings.site_main_infos.update');
        Route::post('site_setting/site_infos/remove-image', [SiteSettingsController::class, 'remove_image'])->name('site_infos.remove_image');
        //to remove album 
        Route::post('site_setting/site_infos/remove-site_settings_albums', [SiteSettingsController::class, 'remove_site_settings_albums'])->name('site_infos.remove_site_settings_albums');
        //for logos 
        Route::post('site_setting/site_infos/remove-site-logo-large-light', [SiteSettingsController::class, 'remove_site_logo_large_light'])->name('site_infos.remove_site_logo_large_light');
        Route::post('site_setting/site_infos/remove_site_logo_small_light', [SiteSettingsController::class, 'remove_site_logo_small_light'])->name('site_infos.remove_site_logo_small_light');
        //---------------
        Route::post('site_setting/site_infos/remove_site_logo_large_dark', [SiteSettingsController::class, 'remove_site_logo_large_dark'])->name('site_infos.remove_site_logo_large_dark');
        Route::post('site_setting/site_infos/remove_site_logo_small_dark', [SiteSettingsController::class, 'remove_site_logo_small_dark'])->name('site_infos.remove_site_logo_small_dark');

        Route::get('site_setting/site_contacts', [SiteSettingsController::class, 'show_contact_informations'])->name('settings.site_contacts.show');
        Route::post('site_setting/update_site_contact/{id?}', [SiteSettingsController::class, 'update_contact_informations'])->name('settings.site_contacts.update');

        Route::get('site_setting/site_socials', [SiteSettingsController::class, 'show_socail_informations'])->name('settings.site_socials.show');
        Route::post('site_setting/update_site_social/{id?}', [SiteSettingsController::class, 'update_social_informations'])->name('settings.site_socials.update');

        Route::get('site_setting/site_metas', [SiteSettingsController::class, 'show_meta_informations'])->name('settings.site_meta.show');
        Route::post('site_setting/update_site_meta/{id?}', [SiteSettingsController::class, 'update_meta_informations'])->name('settings.site_meta.update');

        // ==============   Admin Acount Tab   ==============  //
        Route::get('account_settings', [BackendController::class, 'account_settings'])->name('account_settings');
        Route::post('admin/remove-image', [BackendController::class, 'remove_image'])->name('remove_image');
        Route::patch('account_settings', [BackendController::class, 'update_account_settings'])->name('update_account_settings');


        // ==============   Theme Icon To Style Website Ready ==============  //
        Route::post('/cookie/create/update', [BackendController::class, 'create_update_theme'])->name('create_update_theme');
    });
});
