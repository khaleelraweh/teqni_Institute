<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SupportMenuRequest;
use App\Models\WebMenu;
use DateTimeImmutable;
use Illuminate\Http\Request;

class SupportMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_support_menus , show_support_menus')) {
            return redirect('admin/index');
        }

        $support_menus = WebMenu::query()->where('section', 5)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

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
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;


        $input['section']    = $request->section; // company menu 
        $input['status']     =   $request->status;
        $input['created_by'] = auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $company_menu = WebMenu::create($input);


        if ($company_menu) {
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

        $supportMenu = WebMenu::where('id', $supportMenu)->first();

        return view('backend.support_menus.edit', compact('supportMenu'));
    }

    public function update(SupportMenuRequest $request,  $supportMenu)
    {
        if (!auth()->user()->ability('admin', 'update_support_menus')) {
            return redirect('admin/index');
        }

        $supportMenu = WebMenu::where('id', $supportMenu)->first();

        $input['title']     = $request->title;
        $input['link']      = $request->link;
        $input['icon']      = $request->icon;
        $input['section']    = $request->section;

        $input['status']    =   $request->status;
        $input['updated_by'] =   auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

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

        $supportMenu = WebMenu::where('id', $supportMenu)->first();

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
}
