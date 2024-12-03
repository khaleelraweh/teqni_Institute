<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PoliciesPrivacyMenuRequest;
use App\Http\Requests\Backend\SupportMenuRequest;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PoliciesPrivacyMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_policies_privacy_menus , show_policies_privacy_menus')) {
            return redirect('admin/index');
        }

        $policies_privacy_menus = Menu::query()->where('section', 9)
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

        return view('backend.policies_privacy_menus.index', compact('policies_privacy_menus'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_policies_privacy_menus')) {
            return redirect('admin/index');
        }

        return view('backend.policies_privacy_menus.create');
    }

    public function store(PoliciesPrivacyMenuRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_policies_privacy_menus')) {
            return redirect('admin/index');
        }

        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;

        $input['section']    = 9;

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


        $policies_privacy_menu = Menu::create($input);


        if ($policies_privacy_menu) {
            return redirect()->route('admin.policies_privacy_menus.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.policies_privacy_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_policies_privacy_menus')) {
            return redirect('admin/index');
        }
        return view('backend.policies_privacy_menus.show');
    }


    public function edit($policiesPrivacyMenu)
    {
        if (!auth()->user()->ability('admin', 'update_policies_privacy_menus')) {
            return redirect('admin/index');
        }

        $policiesPrivacyMenu = Menu::where('id', $policiesPrivacyMenu)->first();

        return view('backend.policies_privacy_menus.edit', compact('policiesPrivacyMenu'));
    }

    public function update(PoliciesPrivacyMenuRequest $request,  $policiesPrivacyMenu)
    {
        if (!auth()->user()->ability('admin', 'update_policies_privacy_menus')) {
            return redirect('admin/index');
        }

        $policiesPrivacyMenu = Menu::where('id', $policiesPrivacyMenu)->first();

        $input['title']     = $request->title;
        $input['link']      = $request->link;
        $input['icon']      = $request->icon;
        $input['section']    = 9;

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


        $policiesPrivacyMenu->update($input);

        if ($policiesPrivacyMenu) {
            return redirect()->route('admin.policies_privacy_menus.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.policies_privacy_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($policiesPrivacyMenu)
    {

        if (!auth()->user()->ability('admin', 'delete_policies_privacy_menus')) {
            return redirect('admin/index');
        }

        $policiesPrivacyMenu = Menu::where('id', $policiesPrivacyMenu)->first();

        $policiesPrivacyMenu->delete();

        if ($policiesPrivacyMenu) {
            return redirect()->route('admin.policies_privacy_menus.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.policies_privacy_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function updatePoliciesPrivacyMenuStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Menu::where('id', $data['policies_privacy_menu_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'policies_privacy_menu_id' => $data['policies_privacy_menu_id']]);
        }
    }
}
