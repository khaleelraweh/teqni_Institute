<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TopicsMenuRequest;
use App\Models\WebMenu;
use DateTimeImmutable;
use Illuminate\Http\Request;

class TopicsMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_topics_menus , show_topics_menus')) {
            return redirect('admin/index');
        }

        $topics_menus = WebMenu::query()->where('section', 3)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

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
        $input['link'] = $request->link;
        $input['icon'] = $request->icon;

        // $input['parent_id'] = $request->parent_id;

        $input['section']    = $request->section; // company menu 
        $input['status']     =   $request->status;
        $input['created_by'] = auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $company_menu = WebMenu::create($input);


        if ($company_menu) {
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

        $topicsMenu = WebMenu::where('id', $topicsMenu)->first();

        return view('backend.topics_menus.edit', compact('topicsMenu'));
    }

    public function update(TopicsMenuRequest $request,  $topicsMenu)
    {
        // if (!auth()->user()->ability('admin', 'update_topics_menus')) {
        //     return redirect('admin/index');
        // }

        $topicsMenu = WebMenu::where('id', $topicsMenu)->first();


        $input['title']     = $request->title;
        $input['link']      = $request->link;
        $input['icon']      = $request->icon;
        $input['section']    = $request->section;

        $input['status']    =   $request->status;
        $input['updated_by'] =   auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

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

        $topicsMenu = WebMenu::where('id', $topicsMenu)->first();

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
}
