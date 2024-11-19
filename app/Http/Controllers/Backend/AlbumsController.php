<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AlbumRequest;
use App\Http\Requests\Backend\PageCategoryRequest;
use App\Models\Album;
use App\Models\PageCategory;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class AlbumsController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_albums , show_albums')) {
            return redirect('admin/index');
        }

        $albums = Album::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'created_at', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 100);

        return view('backend.albums.index', compact('albums'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_albums')) {
            return redirect('admin/index');
        }

        return view('backend.albums.create');
    }

    public function store(AlbumRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_albums')) {
            return redirect('admin/index');
        }


        $input['title'] = $request->title;
        $input['description'] = $request->description;

        $input['metadata_title'] = $request->metadata_title;
        $input['metadata_description'] = $request->metadata_description;
        $input['metadata_keywords'] = $request->metadata_keywords;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;

        // Save album profile 
        if ($image = $request->file('album_profile')) {
            $manager = new ImageManager(new Driver());
            $file_name = 'album' . time() . '.' . $image->extension();
            $img = $manager->read($request->file('album_profile'));
            $img->toJpeg(80)->save(base_path('public/assets/albums/' . $file_name));
            $input['album_profile'] = $file_name;
        }

        $album = Album::create($input);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $album->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $album->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/albums/' . $file_name));

                $album->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        if ($album) {
            return redirect()->route('admin.albums.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.albums.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_albums')) {
            return redirect('admin/index');
        }
        return view('backend.albums.show');
    }

    public function edit($album)
    {
        if (!auth()->user()->ability('admin', 'update_albums')) {
            return redirect('admin/index');
        }

        $album = Album::where('id', $album)->first();

        return view('backend.albums.edit', compact('album'));
    }

    public function update(AlbumRequest $request, $album)
    {
        if (!auth()->user()->ability('admin', 'update_albums')) {
            return redirect('admin/index');
        }

        $album = Album::where('id', $album)->first();

        $input['title'] = $request->title;
        $input['description'] = $request->description;

        $input['metadata_title'] = $request->metadata_title;
        $input['metadata_description'] = $request->metadata_description;
        $input['metadata_keywords'] = $request->metadata_keywords;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;




        // Save album profile 
        if ($albumImage = $request->file('album_profile')) {

            if (File::exists('assets/albums/' . $albumImage)) {
                unlink('assets/albums/' . $albumImage);
            }

            $manager = new ImageManager(new Driver());
            $file_name = 'album' . time() . '.' . $albumImage->extension();
            $img = $manager->read($request->file('album_profile'));
            $img->toJpeg(80)->save(base_path('public/assets/albums/' . $file_name));
            $input['album_profile'] = $file_name;
        }

        $album->update($input);




        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $album->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $album->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/albums/' . $file_name));

                $album->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        if ($album) {
            return redirect()->route('admin.albums.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.albums.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($album)
    {
        if (!auth()->user()->ability('admin', 'delete_albums')) {
            return redirect('admin/index');
        }

        // Find the page category
        $album = Album::findOrFail($album);

        // Get all related images
        $images = $album->photos;

        // Loop through each image and delete the file from the storage
        foreach ($images as $image) {
            if (File::exists(public_path('assets/albums/' . $image->file_name))) {
                File::delete(public_path('assets/albums/' . $image->file_name));
            }
            // Delete the image record from the database
            $image->delete();
        }

        // Now delete the page category record
        $album->delete();


        if ($album) {
            return redirect()->route('admin.albums.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.albums.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function remove_image(Request $request)
    {
        if (!auth()->user()->ability('admin', 'delete_albums')) {
            return redirect('admin/index');
        }

        $album = Album::findOrFail($request->album_id);

        $image = $album->photos()->where('id', $request->image_id)->first();
        if (File::exists('assets/albums/' . $image->file_name)) {
            unlink('assets/albums/' . $image->file_name);
        }
        $image->delete();
        return true;
    }

    public function remove_album_image(Request $request)
    {
        $album = Album::findOrFail($request->album_id);

        if ($album->album_profile != '') {
            if (File::exists('assets/albums/' . $album->album_profile)) {
                unlink('assets/albums/' . $album->album_profile);
            }

            $album->album_profile = null;
            $album->save();

            return true;
        }
    }
}
