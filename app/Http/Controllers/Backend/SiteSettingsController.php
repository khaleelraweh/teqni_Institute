<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use illuminate\support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class SiteSettingsController extends Controller
{

    // =============== start info site ===============//
    public function show_main_informations()
    {
        $site_album = SiteSetting::where('key', 'site_name')->get()->first();
        return view('backend.site_infos.index', compact('site_album'));
    }

    public function update_main_informations(Request $request, $id)
    {
        $data = $request->except('_token', 'submit', 'images');

        foreach ($data as $key => $value) {
            $site = SiteSetting::where('key', $key)
                ->where('section', $id)
                ->get()
                ->first()
                ->update([
                    'value' => $value
                ]);
        }


        //------------------ for site image albums start  ---------------//

        // Handle multiple images for 'photos' relation
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/site_settings/' . $file_name));

                // Create and associate the Photo instance
                $siteAlbum = SiteSetting::find($id); // Assuming the ID relates to the SiteSetting instance

                $siteAlbum->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $siteAlbum->photos()->count() + 1,
                ]);
            }
        }

        //------------------ for site image albums end-----------//

        //------------------- For Site Image Start --------------//
        $site_image = SiteSetting::where('key', 'site_img')
            ->where('section', $id)
            ->get()
            ->first();

        if ($image = $request->file('site_img')) {

            if ($site_image->value != null && File::exists('assets/site_settings/' . $site_image->value)) {
                unlink('assets/site_settings/' . $site_image->value);
            }

            $manager = new ImageManager(new Driver());
            $file_name = Str::slug($request->input('site_name.' . app()->getLocale())) . "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('site_img'));

            $img->save(base_path('public/assets/site_settings/' . $file_name));

            $site_image->update([
                'value' => $file_name
            ]);
        }
        //------------------- For Site Image end --------------//

        //------------------- For site_logo_large_light Start  --------------//
        $site_logo_large_light = SiteSetting::where('key', 'site_logo_large_light')
            ->where('section', $id)
            ->get()
            ->first();
        if ($image = $request->file('site_logo_large_light')) {

            if ($site_logo_large_light->value != null && File::exists('assets/site_settings/' . $site_logo_large_light->value)) {
                unlink('assets/site_settings/' . $site_logo_large_light->value);
            }

            $manager = new ImageManager(new Driver());
            $file_name = "site_logo_large_light" . "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('site_logo_large_light'));

            $img->save(base_path('public/assets/site_settings/' . $file_name));

            $site_logo_large_light->update([
                'value' => $file_name
            ]);
        }
        //------------------- For site_logo_large_light end  --------------//


        //------------------- For site_logo_small_light Start  --------------//
        $site_logo_small_light = SiteSetting::where('key', 'site_logo_small_light')
            ->where('section', $id)
            ->get()
            ->first();
        if ($image = $request->file('site_logo_small_light')) {

            if ($site_logo_small_light->value != null && File::exists('assets/site_settings/' . $site_logo_small_light->value)) {
                unlink('assets/site_settings/' . $site_logo_small_light->value);
            }

            $manager = new ImageManager(new Driver());
            $file_name = "site_logo_small_light" . "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('site_logo_small_light'));

            $img->save(base_path('public/assets/site_settings/' . $file_name));

            $site_logo_small_light->update([
                'value' => $file_name
            ]);
        }
        //------------------- For site_logo_small_light end  --------------//

        //----------------------------------------------------------------------------//

        //------------------- For site_logo_large_dark Start  --------------//
        $site_logo_large_dark = SiteSetting::where('key', 'site_logo_large_dark')
            ->where('section', $id)
            ->get()
            ->first();
        if ($image = $request->file('site_logo_large_dark')) {

            if ($site_logo_large_dark->value != null && File::exists('assets/site_settings/' . $site_logo_large_dark->value)) {
                unlink('assets/site_settings/' . $site_logo_large_dark->value);
            }

            $manager = new ImageManager(new Driver());
            $file_name = "site_logo_large_dark" . "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('site_logo_large_dark'));

            $img->save(base_path('public/assets/site_settings/' . $file_name));

            $site_logo_large_dark->update([
                'value' => $file_name
            ]);
        }
        //------------------- For site_logo_large_dark end  --------------//

        //------------------- For site_logo_small_dark Start  --------------//
        $site_logo_small_dark = SiteSetting::where('key', 'site_logo_small_dark')
            ->where('section', $id)
            ->get()
            ->first();
        if ($image = $request->file('site_logo_small_dark')) {

            if ($site_logo_small_dark->value != null && File::exists('assets/site_settings/' . $site_logo_small_dark->value)) {
                unlink('assets/site_settings/' . $site_logo_small_dark->value);
            }

            $manager = new ImageManager(new Driver());
            $file_name = "site_logo_small_dark" . "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('site_logo_small_dark'));

            $img->save(base_path('public/assets/site_settings/' . $file_name));

            $site_logo_small_dark->update([
                'value' => $file_name
            ]);
        }
        //------------------- For site_logo_small_dark end  --------------//


        self::updateCache();

        return redirect()->route('admin.settings.site_main_infos.show')->with([
            'message' => __('panel.updated_successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function remove_image(Request $request)
    {

        $site_image = SiteSetting::findOrFail($request->site_info_id);
        if (File::exists('assets/site_settings/' . $site_image->value)) {
            unlink('assets/site_settings/' . $site_image->value);
            $site_image->value = null;
            $site_image->save();
        }
        if ($site_image->value != null) {
            $site_image->value = null;
            $site_image->save();
        }

        self::updateCache();

        return true;
    }



    public function remove_site_settings_albums(Request $request)
    {

        $site_album = SiteSetting::findOrFail($request->site_album_id);
        $image = $site_album->photos()->where('id', $request->image_id)->first();
        if (File::exists('assets/site_settings/' . $image->file_name)) {
            unlink('assets/site_settings/' . $image->file_name);
        }
        $image->delete();
        return true;
    }

    public function remove_site_logo_large_light(Request $request)
    {

        $site_image = SiteSetting::findOrFail($request->site_info_id);
        if (File::exists('assets/site_settings/' . $site_image->value)) {
            unlink('assets/site_settings/' . $site_image->value);
            $site_image->value = null;
            $site_image->save();
        }
        if ($site_image->value != null) {
            $site_image->value = null;
            $site_image->save();
        }

        self::updateCache();

        return true;
    }

    public function remove_site_logo_small_light(Request $request)
    {

        $site_image = SiteSetting::findOrFail($request->site_info_id);
        if (File::exists('assets/site_settings/' . $site_image->value)) {
            unlink('assets/site_settings/' . $site_image->value);
            $site_image->value = null;
            $site_image->save();
        }
        if ($site_image->value != null) {
            $site_image->value = null;
            $site_image->save();
        }

        self::updateCache();

        return true;
    }
    // =============== end info site ===============//

    //-----------------------------------------------------------------------//
    public function remove_site_logo_large_dark(Request $request)
    {

        $site_image = SiteSetting::findOrFail($request->site_info_id);
        if (File::exists('assets/site_settings/' . $site_image->value)) {
            unlink('assets/site_settings/' . $site_image->value);
            $site_image->value = null;
            $site_image->save();
        }
        if ($site_image->value != null) {
            $site_image->value = null;
            $site_image->save();
        }

        self::updateCache();

        return true;
    }

    public function remove_site_logo_small_dark(Request $request)
    {

        $site_image = SiteSetting::findOrFail($request->site_info_id);
        if (File::exists('assets/site_settings/' . $site_image->value)) {
            unlink('assets/site_settings/' . $site_image->value);
            $site_image->value = null;
            $site_image->save();
        }
        if ($site_image->value != null) {
            $site_image->value = null;
            $site_image->save();
        }

        self::updateCache();

        return true;
    }

    // =============== start contact site ===============//
    public function show_contact_informations()
    {
        return view('backend.site_contacts.index');
    }

    public function update_contact_informations(Request $request, $id)
    {

        $data = $request->except('_token', 'submit');

        foreach ($data as $key => $value) {
            $site = SiteSetting::where('key', $key)
                ->where('section', $id)
                ->get()
                ->first()
                ->update([
                    'value' => $value
                ]);
        }

        self::updateCache();

        return redirect()->route('admin.settings.site_contacts.show')->with([
            'message' => __('panel.updated_successfully'),
            'alert-type' => 'success'
        ]);
    }
    // =============== end contact site ===============//


    // =============== start social site ===============//
    public function show_socail_informations()
    {
        return view('backend.site_socials.index');
    }

    public function update_social_informations(Request $request, $id)
    {

        $data = $request->except('_token', 'submit');

        foreach ($data as $key => $value) {
            $site = SiteSetting::where('key', $key)
                ->where('section', $id)
                ->get()
                ->first()
                ->update([
                    'value' => $value
                ]);
        }

        self::updateCache();

        return redirect()->route('admin.settings.site_socials.show')->with([
            'message' => __('panel.updated_successfully'),
            'alert-type' => 'success'
        ]);
    }

    // =============== end social site ===============//

    // =============== end meta site ===============//
    public function show_meta_informations()
    {
        return view('backend.site_metas.index');
    }

    public function update_meta_informations(Request $request, $id)
    {

        $data = $request->except('_token', 'submit');

        foreach ($data as $key => $value) {
            $site = SiteSetting::where('key', $key)
                ->where('section', $id)
                ->get()
                ->first()
                ->update([
                    'value' => $value
                ]);
        }

        self::updateCache();

        return redirect()->route('admin.settings.site_meta.show')->with([
            'message' => __('panel.updated_successfully'),
            'alert-type' => 'success'
        ]);
    }
    // =============== end meta site ===============//

    // =============== start payment method site ===============//
    public function show_payment_method_informations()
    {
        return view('backend.site_payment_methods.index');
    }

    public function update_payment_method_informations(Request $request, $id)
    {

        $data = $request->except('_token', 'submit');

        foreach ($data as $key => $value) {
            $site = SiteSetting::where('key', $key)
                ->where('section', $id)
                ->get()
                ->first()
                ->update([
                    'value' => $value
                ]);
        }

        self::updateCache();

        return redirect()->route('admin.settings.site_payment_methods.show')->with([
            'message' => __('panel.updated_successfully'),
            'alert-type' => 'success'
        ]);
    }
    // =============== end payment method site ===============//


    // =============== start payment method site ===============//
    public function show_site_counter_informations()
    {
        return view('backend.site_counters.index');
    }

    public function update_site_counter_informations(Request $request, $id)
    {
        $data = $request->except('_token', 'submit');

        foreach ($data as $key => $value) {
            $site = SiteSetting::where('key', $key)
                ->where('section', $id)
                ->get()
                ->first()
                ->update([
                    'value' => $value
                ]);
        }

        self::updateCache();

        return redirect()->route('admin.settings.site_counters.show')->with([
            'message' => __('panel.updated_successfully'),
            'alert-type' => 'success'
        ]);
    }
    // =============== end payment method site ===============//


    // To update cache with new data when updating fields to database because cache will take a day to updated automatacly 
    private function updateCache()
    {
        Cache::forget('siteSettings');
        $siteSettings = Cache()->remember(
            'siteSettings',
            3600,
            fn() => SiteSetting::all()->keyBy('key')
        );

        View::share('siteSettings', $siteSettings);
    }
}
