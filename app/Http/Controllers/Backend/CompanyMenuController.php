<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CompanyMenuRequest;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateTimeImmutable;

class CompanyMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_company_menus , show_company_menus')) {
            return redirect('admin/index');
        }

        $company_menus = Menu::query()->where('section', 6)
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

        return view('backend.company_menus.index', compact('company_menus'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_company_menus')) {
            return redirect('admin/index');
        }

        return view('backend.company_menus.create');
    }

    public function store(CompanyMenuRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_company_menus')) {
            return redirect('admin/index');
        }

        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;

        $input['section']    = 6;

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


        $company_menu = Menu::create($input);


        if ($company_menu) {
            return redirect()->route('admin.company_menus.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.company_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_company_menus')) {
            return redirect('admin/index');
        }
        return view('backend.company_menus.show');
    }


    public function edit($companyMenu)
    {
        if (!auth()->user()->ability('admin', 'update_company_menus')) {
            return redirect('admin/index');
        }

        $companyMenu = Menu::where('id', $companyMenu)->first();

        return view('backend.company_menus.edit', compact('companyMenu'));
    }

    public function update(CompanyMenuRequest $request,  $companyMenu)
    {
        if (!auth()->user()->ability('admin', 'update_company_menus')) {
            return redirect('admin/index');
        }

        $companyMenu = Menu::where('id', $companyMenu)->first();



        $input['title'] = $request->title;
        $input['description'] = $request->description;
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;

        $input['section']    = 6;

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


        $companyMenu->update($input);

        if ($companyMenu) {
            return redirect()->route('admin.company_menus.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.company_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($companyMenu)
    {

        if (!auth()->user()->ability('admin', 'delete_company_menus')) {
            return redirect('admin/index');
        }

        $companyMenu = Menu::where('id', $companyMenu)->first();

        $companyMenu->delete();

        if ($companyMenu) {
            return redirect()->route('admin.company_menus.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.company_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function updateCompanyMenuStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Menu::where('id', $data['company_menu_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'company_menu_id' => $data['company_menu_id']]);
        }
    }
}
