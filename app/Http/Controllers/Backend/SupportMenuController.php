<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SupportMenuRequest;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupportMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_support_menus , show_support_menus')) {
            return redirect('admin/index');
        }

        $support_menus = Menu::query()->where('section', 5)
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

        return view('backend.support_menus.index', compact('support_menus'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_support_menus')) {
            return redirect('admin/index');
        }

        return view('backend.support_menus.create');
    }

    public function store(SupportMenuRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_support_menus')) {
            return redirect('admin/index');
        }

        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;

        $input['section']    = 5;

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


        $support_menu = Menu::create($input);


        if ($support_menu) {
            return redirect()->route('admin.support_menus.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.support_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_support_menus')) {
            return redirect('admin/index');
        }
        return view('backend.support_menus.show');
    }


    public function edit($supportMenu)
    {
        if (!auth()->user()->ability('admin', 'update_support_menus')) {
            return redirect('admin/index');
        }

        $supportMenu = Menu::where('id', $supportMenu)->first();

        return view('backend.support_menus.edit', compact('supportMenu'));
    }

    public function update(SupportMenuRequest $request,  $supportMenu)
    {
        if (!auth()->user()->ability('admin', 'update_support_menus')) {
            return redirect('admin/index');
        }

        $supportMenu = Menu::where('id', $supportMenu)->first();

        $input['title']     = $request->title;
        $input['link']      = $request->link;
        $input['icon']      = $request->icon;
        $input['section']    = 5;

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


        $supportMenu->update($input);

        if ($supportMenu) {
            return redirect()->route('admin.support_menus.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.support_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($supportMenu)
    {

        if (!auth()->user()->ability('admin', 'delete_support_menus')) {
            return redirect('admin/index');
        }

        $supportMenu = Menu::where('id', $supportMenu)->first();

        $supportMenu->delete();

        if ($supportMenu) {
            return redirect()->route('admin.support_menus.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.support_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function updateSupportMenuStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Menu::where('id', $data['support_menu_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'support_menu_id' => $data['support_menu_id']]);
        }
    }
}
