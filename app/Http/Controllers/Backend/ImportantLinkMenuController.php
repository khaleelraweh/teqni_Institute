<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ImportantLinkMenuRequest;
use App\Http\Requests\Backend\SupportMenuRequest;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ImportantLinkMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_important_link_menus , show_important_link_menus')) {
            return redirect('admin/index');
        }

        $important_link_menus = Menu::query()->where('section', 7)
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

        return view('backend.important_link_menus.index', compact('important_link_menus'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_important_link_menus')) {
            return redirect('admin/index');
        }

        return view('backend.important_link_menus.create');
    }

    public function store(ImportantLinkMenuRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_important_link_menus')) {
            return redirect('admin/index');
        }

        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;

        $input['section']    = 7;

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


        $important_link_menu = Menu::create($input);


        if ($important_link_menu) {
            return redirect()->route('admin.important_link_menus.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.important_link_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_important_link_menus')) {
            return redirect('admin/index');
        }
        return view('backend.important_link_menus.show');
    }


    public function edit($importantLinkMenu)
    {
        if (!auth()->user()->ability('admin', 'update_important_link_menus')) {
            return redirect('admin/index');
        }

        $importantLinkMenu = Menu::where('id', $importantLinkMenu)->first();

        return view('backend.important_link_menus.edit', compact('importantLinkMenu'));
    }

    public function update(ImportantLinkMenuRequest $request,  $importantLinkMenu)
    {
        if (!auth()->user()->ability('admin', 'update_important_link_menus')) {
            return redirect('admin/index');
        }

        $importantLinkMenu = Menu::where('id', $importantLinkMenu)->first();

        $input['title']     = $request->title;
        $input['link']      = $request->link;
        $input['icon']      = $request->icon;
        $input['section']    = 7;

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


        $input['status']    =   $request->status;
        $input['updated_by'] =   auth()->user()->full_name;


        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $importantLinkMenu->update($input);

        if ($importantLinkMenu) {
            return redirect()->route('admin.important_link_menus.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.important_link_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($importantLinkMenu)
    {

        if (!auth()->user()->ability('admin', 'delete_important_link_menus')) {
            return redirect('admin/index');
        }

        $importantLinkMenu = Menu::where('id', $importantLinkMenu)->first();

        $importantLinkMenu->delete();

        if ($importantLinkMenu) {
            return redirect()->route('admin.important_link_menus.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.important_link_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function updateImportantLinkMenuStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Menu::where('id', $data['important_link_menu_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'important_link_menu_id' => $data['important_link_menu_id']]);
        }
    }
}
