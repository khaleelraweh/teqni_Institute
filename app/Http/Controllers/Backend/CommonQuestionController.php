<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CommonQuestionRequest;
use App\Models\CommonQuestion;
use DateTimeImmutable;
use Illuminate\Http\Request;

class CommonQuestionController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_common_questions , show_common_questions')) {
            return redirect('admin/index');
        }

        $common_questions = CommonQuestion::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.common_questions.index', compact('common_questions'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_common_questions')) {
            return redirect('admin/index');
        }
        return view('backend.common_questions.create');
    }


    public function store(CommonQuestionRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_common_questions')) {
            return redirect('admin/index');
        }

        $input['title']              =   $request->title;
        $input['description']              =   $request->description;

        // always added 
        $input['status']            =   $request->status;
        $input['views']             =   0;
        $input['created_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;
        // end of always added 

        // Coupon::create($request->validated());
        $common_question = CommonQuestion::create($input);

        if ($common_question) {
            return redirect()->route('admin.common_questions.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.common_questions.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_common_questions')) {
            return redirect('admin/index');
        }
        return view('backend.common_questions.show');
    }

    public function edit($commonQuestion)
    {
        if (!auth()->user()->ability('admin', 'update_common_questions')) {
            return redirect('admin/index');
        }
        // $time = \Carbon\Carbon::parse('')->isoFormat('h:mm a');

        $commonQuestion = CommonQuestion::where('id', $commonQuestion)->first();

        return view('backend.common_questions.edit', compact('commonQuestion'));
    }

    public function update(CommonQuestionRequest $request,  $commonQuestion)
    {
        if (!auth()->user()->ability('admin', 'update_common_questions')) {
            return redirect('admin/index');
        }

        $commonQuestion = CommonQuestion::where('id', $commonQuestion)->first();

        $input['title']                     =   $request->title;
        $input['description']               =   $request->description;


        // always added 
        $input['status']            =   $request->status;
        $input['views']             =   0;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;
        // end of always added 

        //    $commonQuestion->update($request->validated());
        $commonQuestion->update($input);


        if ($commonQuestion) {
            return redirect()->route('admin.common_questions.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.common_questions.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($commonQuestion)
    {
        if (!auth()->user()->ability('admin', 'delete_common_questions')) {
            return redirect('admin/index');
        }

        $commonQuestion = CommonQuestion::where('id', $commonQuestion)->first();

        $commonQuestion->delete();


        if ($commonQuestion) {
            return redirect()->route('admin.common_questions.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.common_questions.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
