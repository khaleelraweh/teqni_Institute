<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class AdvsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_advs , show_advs')) {
            return redirect('admin/index');
        }

        $advs = Post::query()
            ->whereSection(3)
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

        return view('backend.advs.index', compact('advs'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_advs')) {
            return redirect('admin/index');
        }

        $tags = Tag::whereStatus(1)->where('section', 3)->get(['id', 'name']);

        return view('backend.advs.create', compact('tags'));
    }

    public function store(PostRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_advs')) {
            return redirect('admin/index');
        }
        $input['title'] = $request->title;
        $input['content'] = $request->content;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $content = $request->content[$localeKey] ?? '';
            $plainContent = html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5);
            $limitedContent = implode(' ', array_slice(explode(' ', $plainContent), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedContent ?: null;
        }
        $input['metadata_keywords'] = $request->metadata_keywords;

        $input['section']            =   3; // for advertisement
        $input['status']            =   $request->status;
        $input['created_by']        =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $adv = Post::create($input);

        $adv->tags()->attach($request->tags);
        $adv->users()->attach(Auth::user()->id);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i          = $adv->photos->count() + 1;
            $images     = $request->file('images');
            foreach ($images as $image) {
                $manager    = new ImageManager(new Driver());

                $file_name  = $adv->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size  = $image->getSize();
                $file_type  = $image->getMimeType();

                $img        = $manager->read($image);
                $img->save(base_path('public/assets/advs/' . $file_name));

                $adv->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }


        if ($adv) {
            return redirect()->route('admin.advs.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.advs.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_advs')) {
            return redirect('admin/index');
        }
        return view('backend.advs.show');
    }
    public function edit($adv)
    {
        if (!auth()->user()->ability('admin', 'update_advs')) {
            return redirect('admin/index');
        }
        $adv            = Post::where('id', $adv)->first();
        $tags           = Tag::whereStatus(1)->where('section', 3)->get(['id', 'name']);
        return view('backend.advs.edit', compact('adv', 'tags'));
    }

    public function update(PostRequest $request,  $adv)
    {
        if (!auth()->user()->ability('admin', 'update_advs')) {
            return redirect('admin/index');
        }
        $adv = Post::where('id', $adv)->first();

        $input['title']         = $request->title;
        $input['content']       = $request->content;


        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $content                = $request->content[$localeKey] ?? '';
            $plainContent           = html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5);
            $limitedContent         = implode(' ', array_slice(explode(' ', $plainContent), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedContent ?: null;
        }
        $input['metadata_keywords'] = $request->metadata_keywords;

        $input['section']           =   3; // for advs
        $input['status']            =   $request->status;
        $input['created_by']        = auth()->user()->full_name;

        $published_on               = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn                = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']      = $publishedOn;


        $adv->update($input);

        $adv->tags()->sync($request->tags);

        $adv->users()->attach(Auth::user()->id);


        if ($request->hasFile('images') && count($request->images) > 0) {
            $i                  = $adv->photos->count() + 1;
            $images             = $request->file('images');
            foreach ($images as $image) {
                $manager        = new ImageManager(new Driver());

                $file_name      = $adv->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size      = $image->getSize();
                $file_type      = $image->getMimeType();

                $img            = $manager->read($image);
                $img->save(base_path('public/assets/advs/' . $file_name));

                $adv->photos()->create([
                    'file_name'     => $file_name,
                    'file_size'     => $file_size,
                    'file_type'     => $file_type,
                    'file_status'   => 'true',
                    'file_sort'     => $i,
                ]);
                $i++;
            }
        }


        if ($adv) {
            return redirect()->route('admin.advs.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.advs.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($adv)
    {
        if (!auth()->user()->ability('admin', 'delete_advs')) {
            return redirect('admin/index');
        }

        $adv = Post::where('id', $adv)->first();
        if ($adv->photos->count() > 0) {
            foreach ($adv->photos as $photo) {
                if (File::exists('assets/advs/' . $photo->file_name)) {
                    unlink('assets/advs/' . $photo->file_name);
                }
                $photo->delete();
            }
        }
        $adv->delete();

        if ($adv) {
            return redirect()->route('admin.advs.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.advs.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
    public function remove_image(Request $request)
    {
        if (!auth()->user()->ability('admin', 'delete_advs')) {
            return redirect('admin/index');
        }
        $adv = Post::findOrFail($request->course_id);
        $image = $adv->photos()->where('id', $request->image_id)->first();
        if (File::exists('assets/advs/' . $image->file_name)) {
            unlink('assets/advs/' . $image->file_name);
        }
        $image->delete();
        return true;
    }

    public function updateAdvStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Post::where('id', $data['adv_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'adv_id' => $data['adv_id']]);
        }
    }
}
