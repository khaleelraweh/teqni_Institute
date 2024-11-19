<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TagRequest;
use App\Models\Tag;
use DateTimeImmutable;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_tags , show_tags')) {
            return redirect('admin/index');
        }

        $tags = Tag::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.tags.index', compact('tags'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_tags')) {
            return redirect('admin/index');
        }
        return view('backend.tags.create');
    }

    public function store(TagRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_tags')) {
            return redirect('admin/index');
        }

        $input['name']          =   $request->name;
        $input['section']       =   $request->section;
        $input['status']        =   $request->status;
        $input['created_by']    =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $tag = Tag::create($input);

        if ($tag) {
            return redirect()->route('admin.tags.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.tags.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_tags')) {
            return redirect('admin/index');
        }
        return view('backend.tags.show');
    }

    public function edit($tag)
    {
        if (!auth()->user()->ability('admin', 'update_tags')) {
            return redirect('admin/index');
        }

        $tag = Tag::where('id', $tag)->first();
        return view('backend.tags.edit', compact('tag'));
    }

    public function update(TagRequest $request,  $tag)
    {
        if (!auth()->user()->ability('admin', 'update_tags')) {
            return redirect('admin/index');
        }

        $tag = Tag::where('id', $tag)->first();

        $input['name'] = $request->name;
        $input['section']       =   $request->section;
        $input['status']        =   $request->status;
        $input['updated_by']    =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $tag->update($input);

        if ($tag) {
            return redirect()->route('admin.tags.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.tags.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($tag)
    {
        if (!auth()->user()->ability('admin', 'delete_tags')) {
            return redirect('admin/index');
        }

        $tag = Tag::where('id', $tag)->first();


        $tag->deleted_by = auth()->user()->full_name;
        $tag->save();
        $tag->delete();


        if ($tag) {
            return redirect()->route('admin.tags.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.tags.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
