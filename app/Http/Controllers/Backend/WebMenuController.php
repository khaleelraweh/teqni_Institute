<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Icon;
use App\Http\Requests\Backend\WebMenuRequest;
use Illuminate\Http\Request;
use App\Models\WebMenu;
use illuminate\support\Str;
use Intervention\Image\Facades\Image;
use DateTimeImmutable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class WebMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_web_menus , show_web_menus')) {
            return redirect('admin/index');
        }

        $menus = WebMenu::query()->where('section', 1)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);



        return view('backend.web_menus.index', compact('menus'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_web_menus')) {
            return redirect('admin/index');
        }

        $main_menus = WebMenu::tree();

        return view('backend.web_menus.create', compact('main_menus'));
    }

    public function store(WebMenuRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_web_menus')) {
            return redirect('admin/index');
        }

        $input['title'] = $request->title;
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;
        $input['parent_id'] = $request->parent_id;

        $input['section'] = 1;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $webMenu = WebMenu::create($input);


        if ($webMenu) {
            return redirect()->route('admin.web_menus.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.web_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_web_menus')) {
            return redirect('admin/index');
        }
        return view('backend.web_menus.show');
    }

    public function edit($webMenu)
    {
        if (!auth()->user()->ability('admin', 'update_web_menus')) {
            return redirect('admin/index');
        }


        $main_menus = WebMenu::tree();

        $webMenu = WebMenu::where('id', $webMenu)->first();

        return view('backend.web_menus.edit', compact('main_menus', 'webMenu'));
    }

    public function update(WebMenuRequest $request, $webMenu)
    {

        $webMenu = WebMenu::where('id', $webMenu)->first();

        $input['title'] = $request->title;
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;
        $input['parent_id'] = $request->parent_id;
        $input['section'] = 1;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $webMenu->update($input);

        if ($webMenu) {
            return redirect()->route('admin.web_menus.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.web_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }




    public function destroy($webMenu)
    {
        if (!auth()->user()->ability('admin', 'delete_web_menus')) {
            return redirect('admin/index');
        }

        $webMenu = WebMenu::where('id', $webMenu)->first()->delete();

        if ($webMenu) {
            return redirect()->route('admin.web_menus.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.web_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
