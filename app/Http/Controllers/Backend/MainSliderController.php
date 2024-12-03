<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MainSliderRequest;
use App\Models\Slider;
use App\Models\Tag;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MainSliderController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_main_sliders , show_main_sliders')) {
            return redirect('admin/index');
        }

        $mainSliders = Slider::with('firstMedia')
            ->MainSliders()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderByRaw(request()->sort_by == 'published_on'
                ? 'published_on IS NULL, published_on ' . (request()->order_by ?? 'desc')
                : (request()->sort_by ?? 'created_at') . ' ' . (request()->order_by ?? 'desc'))
            ->paginate(\request()->limit_by ?? 100);


        return view('backend.main_sliders.index', compact('mainSliders'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_main_sliders')) {
            return redirect('admin/index');
        }

        $tags = Tag::whereStatus(1)->get(['id', 'name']);

        return view('backend.main_sliders.create', compact('tags'));
    }

    public function store(MainSliderRequest $request)
    {

        if (!auth()->user()->ability('admin', 'create_main_sliders')) {
            return redirect('admin/index');
        }

        $input['title']          =   $request->title;
        $input['subtitle']      = $request->subtitle;
        $input['description']        =   $request->description;
        $input['url']            =   $request->url;
        $input['btn_title']            =   $request->btn_title;
        $input['show_btn_title']            =   $request->show_btn_title;
        $input['target']         =   $request->target;
        $input['section']        =   1;

        $input['show_info']            =   $request->show_info;
        $input['status']            =   $request->status;
        $input['created_by']        =   auth()->user()->full_name;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $description = $request->description[$localeKey] ?? '';
            // Remove all tags and decode HTML entities
            $plainDescription = html_entity_decode(strip_tags($description), ENT_QUOTES | ENT_HTML5);
            // Limit to 30 words
            $limitedDescription = implode(' ', array_slice(explode(' ', $plainDescription), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedDescription ?: null;
        }
        $input['metadata_keywords'] = $request->metadata_keywords;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $published_on = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on'] = $published_on;

        $mainSlider = Slider::create($input);

        $mainSlider->tags()->attach($request->tags);


        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $mainSlider->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $mainSlider->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                // $img->resize(370, 246);
                // Save the image to the desired location
                $img->save(base_path('public/assets/main_sliders/' . $file_name));
                // $img->toJpeg(80)->save(base_path('public/assets/main_sliders/' . $file_name));

                $mainSlider->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        if ($mainSlider) {
            return redirect()->route('admin.main_sliders.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.main_sliders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_sliders')) {
            return redirect('admin/index');
        }

        return view('backend.main_sliders.show');
    }


    public function edit($mainSlider)
    {
        if (!auth()->user()->ability('admin', 'update_main_sliders')) {
            return redirect('admin/index');
        }

        $mainSlider =  Slider::where('id', $mainSlider)->first();
        $tags = Tag::whereStatus(1)->get(['id', 'name']);
        return view('backend.main_sliders.edit', compact('tags', 'mainSlider'));
    }

    public function update(MainSliderRequest $request,  $mainSlider)
    {
        if (!auth()->user()->ability('admin', 'update_main_sliders')) {
            return redirect('admin/index');
        }

        $mainSlider = Slider::where('id', $mainSlider)->first();


        $input['title']          =   $request->title;
        $input['description']        =   $request->description;
        $input['url']            =   $request->url;
        $input['btn_title']            =   $request->btn_title;
        $input['show_btn_title']            =   $request->show_btn_title;
        $input['target']         =   $request->target;
        $input['section']        =   1;

        $input['show_info']            =   $request->show_info;
        $input['status']            =   $request->status;
        $input['updated_by']        =   auth()->user()->full_name;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $description = $request->description[$localeKey] ?? '';
            // Remove all tags and decode HTML entities
            $plainDescription = html_entity_decode(strip_tags($description), ENT_QUOTES | ENT_HTML5);
            // Limit to 30 words
            $limitedDescription = implode(' ', array_slice(explode(' ', $plainDescription), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedDescription ?: null;
        }
        $input['metadata_keywords'] = $request->metadata_keywords;


        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $published_on = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on'] = $published_on;

        $mainSlider->update($input);
        $mainSlider->tags()->sync($request->tags);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $mainSlider->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $mainSlider->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                // $img->resize(370, 246);
                // Save the image to the desired location
                $img->save(base_path('public/assets/main_sliders/' . $file_name));
                // $img->toJpeg(80)->save(base_path('public/assets/main_sliders/' . $file_name));

                $mainSlider->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }



        if ($mainSlider) {
            return redirect()->route('admin.main_sliders.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.main_sliders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function destroy($mainSlider)
    {
        if (!auth()->user()->ability('admin', 'delete_main_sliders')) {
            return redirect('admin/index');
        }

        $mainSlider = Slider::where('id', $mainSlider)->first();


        if ($mainSlider->photos->count() > 0) {
            foreach ($mainSlider->photos as $photo) {
                if (File::exists('assets/main_sliders/' . $photo->file_name)) {
                    unlink('assets/main_sliders/' . $photo->file_name);
                }
                $photo->delete();
            }
        }

        $mainSlider->delete();

        if ($mainSlider) {
            return redirect()->route('admin.main_sliders.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.main_sliders.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_main_sliders')) {
            return redirect('admin/index');
        }


        $slider = Slider::findOrFail($request->slider_id);

        $image = $slider->photos()->where('id', $request->image_id)->first();

        if (File::exists('assets/main_sliders/' . $image->file_name)) {
            unlink('assets/main_sliders/' . $image->file_name);
        }
        $image->delete();

        return true;
    }

    public function updateMainSliderStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Slider::where('id', $data['main_slider_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'main_slider_id' => $data['main_slider_id']]);
        }
    }
}
