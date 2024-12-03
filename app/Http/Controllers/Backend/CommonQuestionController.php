<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CommonQuestionRequest;
use App\Models\CommonQuestion;
use Carbon\Carbon;
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
            ->orderByRaw(request()->sort_by == 'published_on'
                ? 'published_on IS NULL, published_on ' . (request()->order_by ?? 'desc')
                : (request()->sort_by ?? 'created_at') . ' ' . (request()->order_by ?? 'desc'))
            ->paginate(\request()->limit_by ?? 100);

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


        // always added 
        $input['status']            =   $request->status;
        $input['views']             =   0;
        $input['created_by']        =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


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


        // always added 
        $input['status']            =   $request->status;
        $input['views']             =   0;
        $input['updated_by']        =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        //$commonQuestion->update($request->validated());
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

    public function updateCommonQuestionStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            CommonQuestion::where('id', $data['common_question_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'common_question_id' => $data['common_question_id']]);
        }
    }
}
