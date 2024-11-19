<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PresidentSpeechRequest;
use App\Models\PresidentSpeech;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


use Illuminate\Support\Facades\File;

class PresidentSpeechController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_president_speeches , show_president_speeches')) {
            return redirect('admin/index');
        }

        $about_instatutes = PresidentSpeech::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'created_at', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);



        return view('backend.president_speeches.index', compact('about_instatutes'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_president_speeches')) {
            return redirect('admin/index');
        }

        return view('backend.president_speeches.create');
    }

    public function store(PresidentSpeechRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_president_speeches')) {
            return redirect('admin/index');
        }



        $input['title'] = $request->title;
        $input['content'] = $request->content;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;


        if ($image = $request->file('promotional_image')) {

            $manager = new ImageManager(new Driver());
            $file_name = 'pormotional' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('promotional_image'));

            $img->save(base_path('public/assets/president_speeches/' . $file_name));

            $input['promotional_image'] = $file_name;
        }

        $about_instatute = PresidentSpeech::create($input);


        if ($about_instatute) {
            return redirect()->route('admin.president_speeches.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.president_speeches.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_president_speeches')) {
            return redirect('admin/index');
        }
        return view('backend.president_speeches.show');
    }

    public function edit($about_instatute)
    {
        if (!auth()->user()->ability('admin', 'update_president_speeches')) {
            return redirect('admin/index');
        }


        $about_instatute = PresidentSpeech::where('id', $about_instatute)->first();

        return view('backend.president_speeches.edit', compact('about_instatute'));
    }

    public function update(PresidentSpeechRequest $request, $about_instatute)
    {

        $about_instatute = PresidentSpeech::where('id', $about_instatute)->first();

        $input['title'] = $request->title;
        $input['content'] = $request->content;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;



        if ($image = $request->file('promotional_image')) {
            if ($about_instatute->promotional_image != null && File::exists('assets/president_speeches/' . $about_instatute->promotional_image)) {
                unlink('assets/president_speeches/' . $about_instatute->promotional_image);
            }

            $manager = new ImageManager(new Driver());
            $file_name = 'pormotional' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('promotional_image'));

            $img->save(base_path('public/assets/president_speeches/' . $file_name));

            $input['promotional_image'] = $file_name;
        }

        $about_instatute->update($input);

        if ($about_instatute) {
            return redirect()->route('admin.president_speeches.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.president_speeches.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function destroy($about_instatute)
    {
        if (!auth()->user()->ability('admin', 'delete_president_speeches')) {
            return redirect('admin/index');
        }

        $about_instatute = PresidentSpeech::where('id', $about_instatute)->first()->delete();

        if ($about_instatute) {
            return redirect()->route('admin.president_speeches.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.president_speeches.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_president_speeches')) {
            return redirect('admin/index');
        }

        $about_instatute = PresidentSpeech::findOrFail($request->about_instatute_id);
        if (File::exists('assets/president_speeches/' . $about_instatute->promotional_image)) {
            unlink('assets/president_speeches/' . $about_instatute->promotional_image);
            $about_instatute->promotional_image = null;
            $about_instatute->save();
        }
        if ($about_instatute->promotional_image != null) {
            $about_instatute->promotional_image = null;
            $about_instatute->save();
        }

        return true;
    }
}
