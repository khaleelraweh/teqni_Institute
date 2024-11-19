<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CompanyMenuRequest;
use App\Models\WebMenu;
use Illuminate\Http\Request;
use DateTimeImmutable;

class CompanyMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_company_menus , show_company_menus')) {
            return redirect('admin/index');
        }

        $company_menus = WebMenu::query()->where('section', 6)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

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
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;

        // $input['parent_id'] = $request->parent_id;

        $input['section']    = 6; // company menu 
        $input['status']     =   $request->status;
        $input['created_by'] = auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $company_menu = WebMenu::create($input);


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

        $companyMenu = WebMenu::where('id', $companyMenu)->first();

        return view('backend.company_menus.edit', compact('companyMenu'));
    }

    public function update(CompanyMenuRequest $request,  $companyMenu)
    {
        // if (!auth()->user()->ability('admin', 'update_company_menus')) {
        //     return redirect('admin/index');
        // }

        $companyMenu = WebMenu::where('id', $companyMenu)->first();

        $input['section']    = 6;

        $input['title']     = $request->title;
        $input['link']      = $request->link;
        $input['icon']      = $request->icon;

        $input['status']    =   $request->status;
        $input['updated_by'] =   auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

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

        $companyMenu = WebMenu::where('id', $companyMenu)->first();

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
}
