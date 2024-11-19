<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TracksMenuRequest;
use App\Models\WebMenu;
use DateTimeImmutable;
use Illuminate\Http\Request;

class TracksMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_tracks_menus , show_tracks_menus')) {
            return redirect('admin/index');
        }

        $tracks_menus = WebMenu::query()->where('section', 4)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.tracks_menus.index', compact('tracks_menus'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_tracks_menus')) {
            return redirect('admin/index');
        }

        return view('backend.tracks_menus.create');
    }

    public function store(TracksMenuRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_tracks_menus')) {
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
            return redirect()->route('admin.tracks_menus.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.tracks_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_tracks_menus')) {
            return redirect('admin/index');
        }
        return view('backend.tracks_menus.show');
    }


    public function edit($tracksMenu)
    {
        if (!auth()->user()->ability('admin', 'update_tracks_menus')) {
            return redirect('admin/index');
        }

        $tracksMenu = WebMenu::where('id', $tracksMenu)->first();

        return view('backend.tracks_menus.edit', compact('tracksMenu'));
    }

    public function update(TracksMenuRequest $request,  $tracksMenu)
    {
        if (!auth()->user()->ability('admin', 'update_tracks_menus')) {
            return redirect('admin/index');
        }

        $tracksMenu = WebMenu::where('id', $tracksMenu)->first();

        $input['title']     = $request->title;
        $input['link']      = $request->link;
        $input['icon']      = $request->icon;
        $input['section']    = $request->section;

        $input['status']    =   $request->status;
        $input['updated_by'] =   auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $tracksMenu->update($input);

        if ($tracksMenu) {
            return redirect()->route('admin.tracks_menus.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.tracks_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($tracksMenu)
    {

        if (!auth()->user()->ability('admin', 'delete_tracks_menus')) {
            return redirect('admin/index');
        }

        $tracksMenu = WebMenu::where('id', $tracksMenu)->first();

        $tracksMenu->delete();

        if ($tracksMenu) {
            return redirect()->route('admin.tracks_menus.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.tracks_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
