<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TestimonialRequest;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_testimonials , show_testimonials')) {
            return redirect('admin/index');
        }

        $testimonials = Testimonial::query()
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

        return view('backend.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_testimonials')) {
            return redirect('admin/index');
        }
        return view('backend.testimonials.create');
    }


    public function store(TestimonialRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_testimonials')) {
            return redirect('admin/index');
        }

        $input['name']                  =   $request->name;
        $input['title']                 =   $request->title;
        $input['content']               =   $request->content;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $content = $request->content[$localeKey] ?? '';
            // Remove all tags and decode HTML entities
            $plainContent = html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5);
            // Limit to 30 words
            $limitedContent = implode(' ', array_slice(explode(' ', $plainContent), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedContent ?: null;
        }
        $input['metadata_keywords']     = $request->metadata_keywords;


        // always added 
        $input['status']                =   $request->status;
        $input['created_by']            =   auth()->user()->full_name;


        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        if ($image = $request->file('image')) {

            $manager = new ImageManager(new Driver());
            $file_name = 'testimonial' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('image'));

            $img->toJpeg(80)->save(base_path('public/assets/testimonials/' . $file_name));

            $input['image'] = $file_name;
        }


        $testimonial = Testimonial::create($input);

        if ($testimonial) {
            return redirect()->route('admin.testimonials.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.testimonials.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_testimonials')) {
            return redirect('admin/index');
        }
        return view('backend.testimonials.show');
    }

    public function edit($testimonial)
    {
        if (!auth()->user()->ability('admin', 'update_testimonials')) {
            return redirect('admin/index');
        }

        $testimonial = Testimonial::where('id', $testimonial)->first();

        return view('backend.testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request,  $testimonial)
    {
        if (!auth()->user()->ability('admin', 'update_testimonials')) {
            return redirect('admin/index');
        }

        $testimonial = Testimonial::where('id', $testimonial)->first();

        $input['name']                      =   $request->name;
        $input['title']                     =   $request->title;
        $input['content']                      =   $request->content;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $content = $request->content[$localeKey] ?? '';
            // Remove all tags and decode HTML entities
            $plainContent = html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5);
            // Limit to 30 words
            $limitedContent = implode(' ', array_slice(explode(' ', $plainContent), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedContent ?: null;
        }
        $input['metadata_keywords'] = $request->metadata_keywords;


        // always added 
        $input['status']                    =   $request->status;
        $input['updated_by']                =   auth()->user()->full_name;


        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        if ($image = $request->file('image')) {
            if ($testimonial->image != null && File::exists('assets/testimonials/' . $testimonial->image)) {
                unlink('assets/testimonials/' . $testimonial->image);
            }

            $manager = new ImageManager(new Driver());
            $file_name = 'question_video' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('image'));


            $img->toJpeg(80)->save(base_path('public/assets/testimonials/' . $file_name));

            $input['image'] = $file_name;
        }



        //    $commonQuestion->update($request->validated());
        $testimonial->update($input);


        if ($testimonial) {
            return redirect()->route('admin.testimonials.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.testimonials.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($testimonial)
    {
        if (!auth()->user()->ability('admin', 'delete_testimonials')) {
            return redirect('admin/index');
        }

        $testimonial = Testimonial::where('id', $testimonial)->first();


        // first: delete image from users path 
        if (File::exists('assets/testimonials/' . $testimonial->image)) {
            unlink('assets/testimonials/' . $testimonial->image);
        }

        $testimonial->deleted_by = auth()->user()->full_name;
        $testimonial->save();

        //second : delete customer from users table
        $testimonial->delete();


        if ($testimonial) {
            return redirect()->route('admin.testimonials.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.testimonials.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_testimonials')) {
            return redirect('admin/index');
        }

        $testimonial = Testimonial::findOrFail($request->testimonial_id);
        if (File::exists('assets/testimonials/' . $testimonial->image)) {
            unlink('assets/testimonials/' . $testimonial->image);
            $testimonial->image = null;
            $testimonial->save();
        }
        if ($testimonial->image != null) {
            $testimonial->image = null;
            $testimonial->save();
        }

        return true;
    }

    public function updateTestimonialStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Testimonial::where('id', $data['testimonial_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'testimonial_id' => $data['testimonial_id']]);
        }
    }
}
