<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CommonQuestionVideoRequest;
use App\Models\CommonQuestionVideo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class CommonQuestionVideoController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_common_question_videos , show_common_question_videos')) {
            return redirect('admin/index');
        }

        $common_questions = CommonQuestionVideo::query()
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

        return view('backend.common_question_videos.index', compact('common_questions'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_common_question_videos')) {
            return redirect('admin/index');
        }
        return view('backend.common_question_videos.create');
    }


    public function store(CommonQuestionVideoRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_common_question_videos')) {
            return redirect('admin/index');
        }

        $input['title']                 =   $request->title;
        $input['link']                  =   $request->link;

        // always added 
        $input['status']                =   $request->status;
        $input['created_by']            =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        if ($image = $request->file('question_video_image')) {

            $manager = new ImageManager(new Driver());
            $file_name = 'questionVideo' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('question_video_image'));

            $img->toJpeg(80)->save(base_path('public/assets/common_question_videos/' . $file_name));


            $input['question_video_image'] = $file_name;
        }


        $common_question = CommonQuestionVideo::create($input);

        if ($common_question) {
            return redirect()->route('admin.common_question_videos.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.common_question_videos.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_common_question_videos')) {
            return redirect('admin/index');
        }
        return view('backend.common_question_videos.show');
    }

    public function edit($commonQuestion)
    {
        if (!auth()->user()->ability('admin', 'update_common_question_videos')) {
            return redirect('admin/index');
        }
        // $time = \Carbon\Carbon::parse('')->isoFormat('h:mm a');

        $commonQuestion = CommonQuestionVideo::where('id', $commonQuestion)->first();

        return view('backend.common_question_videos.edit', compact('commonQuestion'));
    }

    public function update(CommonQuestionVideoRequest $request,  $commonQuestion)
    {
        if (!auth()->user()->ability('admin', 'update_common_question_videos')) {
            return redirect('admin/index');
        }

        $commonQuestion = CommonQuestionVideo::where('id', $commonQuestion)->first();

        $input['title']                     =   $request->title;
        $input['link']                      =   $request->link;

        // always added 
        $input['status']                    =   $request->status;
        $input['updated_by']                =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        if ($image = $request->file('question_video_image')) {
            if ($commonQuestion->question_video_image != null && File::exists('assets/common_question_videos/' . $commonQuestion->question_video_image)) {
                unlink('assets/common_question_videos/' . $commonQuestion->question_video_image);
            }

            $manager = new ImageManager(new Driver());
            $file_name = 'question_video' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('question_video_image'));


            $img->toJpeg(80)->save(base_path('public/assets/common_question_videos/' . $file_name));

            $input['question_video_image'] = $file_name;
        }



        //    $commonQuestion->update($request->validated());
        $commonQuestion->update($input);


        if ($commonQuestion) {
            return redirect()->route('admin.common_question_videos.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.common_question_videos.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($commonQuestion)
    {
        if (!auth()->user()->ability('admin', 'delete_common_question_videos')) {
            return redirect('admin/index');
        }

        $commonQuestion = CommonQuestionVideo::where('id', $commonQuestion)->first();


        // first: delete image from users path 
        if (File::exists('assets/common_question_videos/' . $commonQuestion->question_video_image)) {
            unlink('assets/common_question_videos/' . $commonQuestion->question_video_image);
        }

        $commonQuestion->deleted_by = auth()->user()->full_name;
        $commonQuestion->save();

        //second : delete customer from users table
        $commonQuestion->delete();


        if ($commonQuestion) {
            return redirect()->route('admin.common_question_videos.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.common_question_videos.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_common_question_videos')) {
            return redirect('admin/index');
        }

        $commonQuestion = CommonQuestionVideo::findOrFail($request->common_question_video_id);
        if (File::exists('assets/common_question_videos/' . $commonQuestion->question_video_image)) {
            unlink('assets/common_question_videos/' . $commonQuestion->question_video_image);
            $commonQuestion->question_video_image = null;
            $commonQuestion->save();
        }
        if ($commonQuestion->question_video_image != null) {
            $commonQuestion->question_video_image = null;
            $commonQuestion->save();
        }

        return true;
    }

    public function updateCommonQuestionVideoStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            CommonQuestionVideo::where('id', $data['common_question_video_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'common_question_video_id' => $data['common_question_video_id']]);
        }
    }
}
