<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AlbumRequest;
use App\Http\Requests\Backend\PageCategoryRequest;
use App\Http\Requests\Backend\PlaylistRequest;
use App\Models\Album;
use App\Models\PageCategory;
use App\Models\Playlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class PlaylistsController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_playlists , show_playlists')) {
            return redirect('admin/index');
        }

        $playlists = Playlist::query()
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

        return view('backend.playlists.index', compact('playlists'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_playlists')) {
            return redirect('admin/index');
        }

        return view('backend.playlists.create');
    }

    public function store(PlaylistRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_playlists')) {
            return redirect('admin/index');
        }


        $input['title'] = $request->title;
        $input['description'] = $request->description;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $description = $request->description[$localeKey] ?? '';
            // Remove all tags and decode HTML entities
            $plainDescription = html_entity_decode(strip_tags($description), ENT_QUOTES | ENT_HTML5);
            // Limit to 30 words
            $limitedDescription = implode(' ', array_slice(explode(' ', $plainDescription), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedDescription ?: null;
        }
        $input['metadata_keywords'] = $request->metadata_keywords;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $playlist = Playlist::create($input);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $playlist->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $playlist->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/playlists/' . $file_name));

                $playlist->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        $playlist->videoLinks()->delete();
        if ($request->videoLinks) {
            $playlist->videoLinks()->createMany($request->videoLinks);
        }

        if ($playlist) {
            return redirect()->route('admin.playlists.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.playlists.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_playlists')) {
            return redirect('admin/index');
        }
        return view('backend.playlists.show');
    }

    public function edit($playlist)
    {
        if (!auth()->user()->ability('admin', 'update_playlists')) {
            return redirect('admin/index');
        }

        $playlist = Playlist::where('id', $playlist)->first();

        return view('backend.playlists.edit', compact('playlist'));
    }

    public function update(PlaylistRequest $request, $playlist)
    {
        if (!auth()->user()->ability('admin', 'update_playlists')) {
            return redirect('admin/index');
        }

        $playlist = Playlist::where('id', $playlist)->first();

        $input['title'] = $request->title;
        $input['description'] = $request->description;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $description = $request->description[$localeKey] ?? '';
            // Remove all tags and decode HTML entities
            $plainDescription = html_entity_decode(strip_tags($description), ENT_QUOTES | ENT_HTML5);
            // Limit to 30 words
            $limitedDescription = implode(' ', array_slice(explode(' ', $plainDescription), 0, 30));
            $input['metadata_description'][$localeKey] = $request->metadata_description[$localeKey]
                ?: $limitedDescription ?: null;
        }
        $input['metadata_keywords'] = $request->metadata_keywords;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $playlist->update($input);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $playlist->photos->count() + 1;

            $images = $request->file('images');

            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $playlist->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/playlists/' . $file_name));

                $playlist->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }

        $playlist->videoLinks()->delete();
        if ($request->videoLinks) {
            $playlist->videoLinks()->createMany($request->videoLinks);
        }

        if ($playlist) {
            return redirect()->route('admin.playlists.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.playlists.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($playlist)
    {
        if (!auth()->user()->ability('admin', 'delete_playlists')) {
            return redirect('admin/index');
        }

        // Find the page category
        $playlist = Playlist::findOrFail($playlist);

        // Get all related images
        $images = $playlist->photos;

        // Loop through each image and delete the file from the storage
        foreach ($images as $image) {
            if (File::exists(public_path('assets/playlists/' . $image->file_name))) {
                File::delete(public_path('assets/playlists/' . $image->file_name));
            }
            // Delete the image record from the database
            $image->delete();
        }

        // Now delete the page category record
        $playlist->delete();


        if ($playlist) {
            return redirect()->route('admin.playlists.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.playlists.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {
        if (!auth()->user()->ability('admin', 'delete_playlists')) {
            return redirect('admin/index');
        }
        $playlist = Playlist::findOrFail($request->playlist_id);
        $image = $playlist->photos()->where('id', $request->image_id)->first();
        if (File::exists('assets/playlists/' . $image->file_name)) {
            unlink('assets/playlists/' . $image->file_name);
        }
        $image->delete();
        return true;
    }

    public function updatePlaylistStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Album::where('id', $data['playlist_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'playlist_id' => $data['playlist_id']]);
        }
    }
}
