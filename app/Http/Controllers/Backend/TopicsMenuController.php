<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TopicsMenuRequest;
use App\Models\Menu;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Request;

class TopicsMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_topics_menus , show_topics_menus')) {
            return redirect('admin/index');
        }

        $topics_menus = Menu::query()->where('section', 3)
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

        return view('backend.topics_menus.index', compact('topics_menus'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_topics_menus')) {
            return redirect('admin/index');
        }

        return view('backend.topics_menus.create');
    }

    public function store(TopicsMenuRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_topics_menus')) {
            return redirect('admin/index');
        }

        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;


        $input['section']    = 3;

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


        $input['status']     =   $request->status;
        $input['created_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $topics_menu = Menu::create($input);


        if ($topics_menu) {
            return redirect()->route('admin.topics_menus.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.topics_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_topics_menus')) {
            return redirect('admin/index');
        }
        return view('backend.topics_menus.show');
    }


    public function edit($topicsMenu)
    {
        if (!auth()->user()->ability('admin', 'update_topics_menus')) {
            return redirect('admin/index');
        }

        $topicsMenu = Menu::where('id', $topicsMenu)->first();

        return view('backend.topics_menus.edit', compact('topicsMenu'));
    }

    public function update(TopicsMenuRequest $request,  $topicsMenu)
    {
        if (!auth()->user()->ability('admin', 'update_topics_menus')) {
            return redirect('admin/index');
        }

        $topicsMenu = Menu::where('id', $topicsMenu)->first();


        $input['title']     = $request->title;
        $input['description'] = $request->description;
        $input['link']      = $request->link;
        $input['icon']      = $request->icon;
        $input['section']    = 3;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $description = $request->description[$localeKey] ?? '';
            $plainDescription = html_entity_decode(strip_tags($description), ENT_QUOTES | ENT_HTML5);
            $limitedDescription = implode(' ', array_slice(explode(' ', $plainDescription), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedDescription ?: null;
        }
        $input['metadata_keywords'] = $request->metadata_keywords;


        $input['status']    =   $request->status;
        $input['updated_by'] =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $topicsMenu->update($input);

        if ($topicsMenu) {
            return redirect()->route('admin.topics_menus.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.topics_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($topicsMenu)
    {

        if (!auth()->user()->ability('admin', 'delete_topics_menus')) {
            return redirect('admin/index');
        }

        $topicsMenu = Menu::where('id', $topicsMenu)->first();

        $topicsMenu->delete();

        if ($topicsMenu) {
            return redirect()->route('admin.topics_menus.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.topics_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function updateTopicsMenuStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Menu::where('id', $data['topics_menu_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'topics_menu_id' => $data['topics_menu_id']]);
        }
    }
}
