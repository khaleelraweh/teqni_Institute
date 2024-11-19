<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CollegeMenuRequest;
use App\Http\Requests\Backend\WebMenuRequest;
use App\Models\WebMenu;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;


class CollegeMenuController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_college_menus , show_college_menus')) {
            return redirect('admin/index');
        }

        $college_menus = WebMenu::query()->where('section', 2)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'created_at', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.college_menus.index', compact('college_menus'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_college_menus')) {
            return redirect('admin/index');
        }

        $main_menus = WebMenu::tree();

        return view('backend.college_menus.create', compact('main_menus'));
    }

    public function store(CollegeMenuRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_college_menus')) {
            return redirect('admin/index');
        }

        $input['title']         = $request->title;
        $input['description']   = $request->description;
        $input['link']          = $request->link;
        $input['icon']          = $request->icon;
        $input['parent_id']     = $request->parent_id;

        $input['section']       = 2;

        $input['metadata_title']        = $request->metadata_title;
        $input['metadata_description']  = $request->metadata_description;
        $input['metadata_keywords']     = $request->metadata_keywords;


        $input['status']        =   $request->status;
        $input['created_by']    = auth()->user()->full_name;

        $webMenu = WebMenu::create($input);


        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $webMenu->photos->count() + 1;
            $images = $request->file('images');
            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $webMenu->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/college_menus/' . $file_name));

                $webMenu->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }


        if ($webMenu) {
            return redirect()->route('admin.college_menus.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.college_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_college_menus')) {
            return redirect('admin/index');
        }
        return view('backend.college_menus.show');
    }

    public function edit($college_menu)
    {
        if (!auth()->user()->ability('admin', 'update_college_menus')) {
            return redirect('admin/index');
        }

        $main_menus = WebMenu::tree();
        $college_menu = WebMenu::where('id', $college_menu)->first();

        return view('backend.college_menus.edit', compact('main_menus', 'college_menu'));
    }

    public function update(CollegeMenuRequest $request, $college_menu)
    {

        $college_menu = WebMenu::where('id', $college_menu)->first();

        $input['title']         = $request->title;
        $input['description']   = $request->description;
        $input['link']          = $request->link;
        $input['icon']          = $request->icon;
        $input['parent_id']     = $request->parent_id;

        $input['section']       = 2;

        $input['metadata_title']        = $request->metadata_title;
        $input['metadata_description']  = $request->metadata_description;
        $input['metadata_keywords']     = $request->metadata_keywords;


        $input['status']        =   $request->status;
        $input['created_by']    = auth()->user()->full_name;

        $college_menu->update($input);

        if ($request->hasFile('images') && count($request->images) > 0) {
            $i = $college_menu->photos->count() + 1;
            $images = $request->file('images');
            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $college_menu->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/college_menus/' . $file_name));

                $college_menu->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        if ($college_menu) {
            return redirect()->route('admin.college_menus.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.college_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function destroy($college_menu)
    {
        if (!auth()->user()->ability('admin', 'delete_college_menus')) {
            return redirect('admin/index');
        }

        $college_menu = WebMenu::where('id', $college_menu)->first();
        if ($college_menu->photos->count() > 0) {
            foreach ($college_menu->photos as $photo) {
                if (File::exists('assets/college_menus/' . $photo->file_name)) {
                    unlink('assets/college_menus/' . $photo->file_name);
                }
                $photo->delete();
            }
        }
        $college_menu->delete();

        if ($college_menu) {
            return redirect()->route('admin.college_menus.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.college_menus.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {
        if (!auth()->user()->ability('admin', 'delete_college_menus')) {
            return redirect('admin/index');
        }
        $college_menu = WebMenu::findOrFail($request->college_menu_id);
        $image = $college_menu->photos()->where('id', $request->image_id)->first();
        if (File::exists('assets/college_menus/' . $image->file_name)) {
            unlink('assets/college_menus/' . $image->file_name);
        }
        $image->delete();
        return true;
    }
}
