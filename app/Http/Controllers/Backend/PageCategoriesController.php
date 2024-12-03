<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PageCategoryRequest;
use App\Models\PageCategory;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;



class PageCategoriesController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_page_categories , show_page_categories')) {
            return redirect('admin/index');
        }

        $page_categories = PageCategory::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            // ->orderBy(\request()->sort_by ?? 'created_at', \request()->order_by ?? 'desc')
            // ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->orderByRaw(request()->sort_by == 'published_on'
                ? 'published_on IS NULL, published_on ' . (request()->order_by ?? 'desc')
                : (request()->sort_by ?? 'created_at') . ' ' . (request()->order_by ?? 'desc'))
            ->paginate(\request()->limit_by ?? 100);

        return view('backend.page_categories.index', compact('page_categories'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_page_categories')) {
            return redirect('admin/index');
        }

        return view('backend.page_categories.create');
    }

    public function store(PageCategoryRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_page_categories')) {
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


        $page_category = PageCategory::create($input);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $page_category->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $page_category->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/page_categories/' . $file_name));

                $page_category->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        if ($page_category) {
            return redirect()->route('admin.page_categories.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.page_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_page_categories')) {
            return redirect('admin/index');
        }
        return view('backend.page_categories.show');
    }

    public function edit($page_category)
    {
        if (!auth()->user()->ability('admin', 'update_page_categories')) {
            return redirect('admin/index');
        }

        $page_category = PageCategory::where('id', $page_category)->first();

        return view('backend.page_categories.edit', compact('page_category'));
    }

    public function update(PageCategoryRequest $request, $page_category)
    {
        if (!auth()->user()->ability('admin', 'update_page_categories')) {
            return redirect('admin/index');
        }

        $page_category = PageCategory::where('id', $page_category)->first();

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

        $page_category->update($input);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $page_category->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $page_category->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/page_categories/' . $file_name));

                $page_category->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        if ($page_category) {
            return redirect()->route('admin.page_categories.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.page_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($page_category)
    {
        if (!auth()->user()->ability('admin', 'delete_page_categories')) {
            return redirect('admin/index');
        }

        // Find the page category
        $page_category = PageCategory::findOrFail($page_category);

        // Get all related images
        $images = $page_category->photos;

        // Loop through each image and delete the file from the storage
        foreach ($images as $image) {
            if (File::exists(public_path('assets/page_categories/' . $image->file_name))) {
                File::delete(public_path('assets/page_categories/' . $image->file_name));
            }
            // Delete the image record from the database
            $image->delete();
        }

        // Now delete the page category record
        $page_category->delete();


        if ($page_category) {
            return redirect()->route('admin.page_categories.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.page_categories.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {
        if (!auth()->user()->ability('admin', 'delete_page_categories')) {
            return redirect('admin/index');
        }
        $page_category = PageCategory::findOrFail($request->page_category_id);
        $image = $page_category->photos()->where('id', $request->image_id)->first();
        if (File::exists('assets/page_categories/' . $image->file_name)) {
            unlink('assets/page_categories/' . $image->file_name);
        }
        $image->delete();
        return true;
    }

    public function updatePageCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            PageCategory::where('id', $data['page_category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_category_id' => $data['page_category_id']]);
        }
    }
}
