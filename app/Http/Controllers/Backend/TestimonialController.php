<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CommonQuestionVideoRequest;
use App\Http\Requests\Backend\TestimonialRequest;
use App\Models\CommonQuestionVideo;
use App\Models\Testimonial;
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
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

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

        // always added 
        $input['status']                =   $request->status;
        $input['created_by']            =   auth()->user()->full_name;

        if ($image = $request->file('image')) {

            $manager = new ImageManager(new Driver());
            $file_name = 'questionVideo' . '_' . time() .  "." . $image->getClientOriginalExtension();

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

        // always added 
        $input['status']                    =   $request->status;
        $input['updated_by']                =   auth()->user()->full_name;


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
}
