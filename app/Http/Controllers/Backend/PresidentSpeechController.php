<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PresidentSpeechRequest;
use App\Models\PresidentSpeech;
use Carbon\Carbon;
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

        $president_speeches = PresidentSpeech::query()
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

        return view('backend.president_speeches.index', compact('president_speeches'));
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


        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        if ($image = $request->file('promotional_image')) {

            $manager = new ImageManager(new Driver());
            $file_name = 'pormotional' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('promotional_image'));

            $img->save(base_path('public/assets/president_speeches/' . $file_name));

            $input['promotional_image'] = $file_name;
        }

        $president_speech = PresidentSpeech::create($input);


        if ($president_speech) {
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

    public function edit($president_speech)
    {
        if (!auth()->user()->ability('admin', 'update_president_speeches')) {
            return redirect('admin/index');
        }


        $president_speech = PresidentSpeech::where('id', $president_speech)->first();

        return view('backend.president_speeches.edit', compact('president_speech'));
    }

    public function update(PresidentSpeechRequest $request, $president_speech)
    {

        $president_speech = PresidentSpeech::where('id', $president_speech)->first();

        $input['title'] = $request->title;
        $input['content'] = $request->content;


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


        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;



        if ($image = $request->file('promotional_image')) {
            if ($president_speech->promotional_image != null && File::exists('assets/president_speeches/' . $president_speech->promotional_image)) {
                unlink('assets/president_speeches/' . $president_speech->promotional_image);
            }

            $manager = new ImageManager(new Driver());
            $file_name = 'pormotional' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('promotional_image'));

            $img->save(base_path('public/assets/president_speeches/' . $file_name));

            $input['promotional_image'] = $file_name;
        }

        $president_speech->update($input);

        if ($president_speech) {
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


    public function destroy($president_speech)
    {
        if (!auth()->user()->ability('admin', 'delete_president_speeches')) {
            return redirect('admin/index');
        }

        $president_speech = PresidentSpeech::where('id', $president_speech)->first()->delete();

        if ($president_speech) {
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

        $president_speech = PresidentSpeech::findOrFail($request->president_speech_id);
        if (File::exists('assets/president_speeches/' . $president_speech->promotional_image)) {
            unlink('assets/president_speeches/' . $president_speech->promotional_image);
            $president_speech->promotional_image = null;
            $president_speech->save();
        }
        if ($president_speech->promotional_image != null) {
            $president_speech->promotional_image = null;
            $president_speech->save();
        }

        return true;
    }

    public function updatePresidentSpeechStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            PresidentSpeech::where('id', $data['president_speech_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'president_speech_id' => $data['president_speech_id']]);
        }
    }
}
