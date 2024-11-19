<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_news , show_news')) {
            return redirect('admin/index');
        }

        $news = Post::query()
            ->whereSection(2)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.news.index', compact('news'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_news')) {
            return redirect('admin/index');
        }

        $tags = Tag::whereStatus(1)->where('section', 3)->get(['id', 'name']);

        return view('backend.news.create', compact('tags'));
    }

    public function store(PostRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_news')) {
            return redirect('admin/index');
        }
        $input['title'] = $request->title;
        $input['content'] = $request->content;

        $input['metadata_title'] = $request->metadata_title;
        $input['metadata_description'] = $request->metadata_description;
        $input['metadata_keywords'] = $request->metadata_keywords;

        $input['section']            =   2; // for news
        $input['status']            =   $request->status;
        $input['created_by']        =   auth()->user()->full_name;


        $posts = Post::create($input);

        $posts->tags()->attach($request->tags);
        $posts->users()->attach(Auth::user()->id);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $posts->photos->count() + 1;
            $images = $request->file('images');
            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $posts->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/news/' . $file_name));

                $posts->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }


        if ($posts) {
            return redirect()->route('admin.news.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.news.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_news')) {
            return redirect('admin/index');
        }
        return view('backend.news.show');
    }
    public function edit($new)
    {
        if (!auth()->user()->ability('admin', 'update_news')) {
            return redirect('admin/index');
        }
        $new = Post::where('id', $new)->first();
        $tags = Tag::whereStatus(1)->where('section', 3)->get(['id', 'name']);
        return view('backend.news.edit', compact('new', 'tags'));
    }

    public function update(PostRequest $request,  $new)
    {
        if (!auth()->user()->ability('admin', 'update_news')) {
            return redirect('admin/index');
        }
        $new = Post::where('id', $new)->first();

        $input['title'] = $request->title;
        $input['content'] = $request->content;


        $input['metadata_title'] = $request->metadata_title;
        $input['metadata_description'] = $request->metadata_description;
        $input['metadata_keywords'] = $request->metadata_keywords;

        $input['section']            =   2; // for news
        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;


        $new->update($input);

        $new->tags()->sync($request->tags);

        $new->users()->attach(Auth::user()->id);


        if ($request->hasFile('images') && count($request->images) > 0) {
            $i = $new->photos->count() + 1;
            $images = $request->file('images');
            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $new->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/news/' . $file_name));

                $new->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }


        if ($new) {
            return redirect()->route('admin.news.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.news.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($new)
    {
        if (!auth()->user()->ability('admin', 'delete_news')) {
            return redirect('admin/index');
        }

        $new = Post::where('id', $new)->first();
        if ($new->photos->count() > 0) {
            foreach ($new->photos as $photo) {
                if (File::exists('assets/news/' . $photo->file_name)) {
                    unlink('assets/news/' . $photo->file_name);
                }
                $photo->delete();
            }
        }
        $new->delete();

        if ($new) {
            return redirect()->route('admin.news.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.news.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
    public function remove_image(Request $request)
    {
        if (!auth()->user()->ability('admin', 'delete_news')) {
            return redirect('admin/index');
        }
        $new = Post::findOrFail($request->course_id);
        $image = $new->photos()->where('id', $request->image_id)->first();
        if (File::exists('assets/news/' . $image->file_name)) {
            unlink('assets/news/' . $image->file_name);
        }
        $image->delete();
        return true;
    }
}
