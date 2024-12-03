<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PageRequest;
use App\Models\Page;
use App\Models\PageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;

class PagesController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_pages , show_pages')) {
            return redirect('admin/index');
        }

        $pages = Page::query()
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

        return view('backend.pages.index', compact('pages'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin/index');
        }
        $page_categories = PageCategory::whereStatus(1)->get(['id', 'title']);
        return view('backend.pages.create', compact('page_categories'));
    }

    public function store(PageRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin/index');
        }

        $input['title']                 = $request->title;
        $input['content']               = $request->content;
        $input['page_category_id']      =   $request->page_category_id;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $content = $request->content[$localeKey] ?? '';
            // Remove all tags and decode HTML entities
            $plainContent = html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5);
            // Limit to 30 words
            $limitedContent = implode(' ', array_slice(explode(' ', $plainContent), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedContent ?: null;
        }
        $input['metadata_keywords']     = $request->metadata_keywords;

        $input['status']                =   $request->status;
        $input['created_by']            = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $page = Page::create($input);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $page->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $page->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/pages/' . $file_name));

                $page->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        if ($page) {
            return redirect()->route('admin.pages.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_pages')) {
            return redirect('admin/index');
        }
        return view('backend.pages.show');
    }

    public function edit($page)
    {
        if (!auth()->user()->ability('admin', 'update_pages')) {
            return redirect('admin/index');
        }

        $page_categories = PageCategory::whereStatus(1)->get(['id', 'title']);
        $page = Page::where('id', $page)->first();

        return view('backend.pages.edit', compact('page', 'page_categories'));
    }

    public function update(PageRequest $request, $page)
    {

        $page = Page::where('id', $page)->first();

        $input['title'] = $request->title;
        $input['content'] = $request->content;

        $input['page_category_id']   =   $request->page_category_id;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $content = $request->content[$localeKey] ?? '';
            // Remove all tags and decode HTML entities
            $plainContent = html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5);
            // Limit to 30 words
            $limitedContent = implode(' ', array_slice(explode(' ', $plainContent), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedContent ?: null;
        }
        $input['metadata_keywords'] = $request->metadata_keywords;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $page->update($input);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $page->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $page->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/pages/' . $file_name));

                $page->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        if ($page) {
            return redirect()->route('admin.pages.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($page)
    {
        if (!auth()->user()->ability('admin', 'delete_pages')) {
            return redirect('admin/index');
        }

        // Find the page category
        $page = Page::findOrFail($page);

        // Get all related images
        $images = $page->photos;

        // Loop through each image and delete the file from the storage
        foreach ($images as $image) {
            if (File::exists(public_path('assets/pages/' . $image->file_name))) {
                File::delete(public_path('assets/pages/' . $image->file_name));
            }
            // Delete the image record from the database
            $image->delete();
        }

        // Now delete the page category record
        $page->delete();

        // $page = Page::where('id', $page)->first()->delete();

        if ($page) {
            return redirect()->route('admin.pages.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {
        if (!auth()->user()->ability('admin', 'delete_pages')) {
            return redirect('admin/index');
        }
        $page = Page::findOrFail($request->page_id);
        $image = $page->photos()->where('id', $request->image_id)->first();
        if (File::exists('assets/pages/' . $image->file_name)) {
            unlink('assets/pages/' . $image->file_name);
        }
        $image->delete();
        return true;
    }

    public function updatePageStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Page::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }
}
