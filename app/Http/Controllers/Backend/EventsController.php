<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EventRequest;
use App\Models\Event;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class EventsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_events , show_events')) {
            return redirect('admin/index');
        }

        $events = Event::query()
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

        return view('backend.events.index', compact('events'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_events')) {
            return redirect('admin/index');
        }
        $tags = Tag::whereStatus(1)->where('section', 3)->get(['id', 'name']);
        return view('backend.events.create', compact('tags'));
    }

    public function store(EventRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_events')) {
            return redirect('admin/index');
        }
        $input['title']                 = $request->title;
        $input['content']               = $request->content;

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
        $input['metadata_keywords']     = $request->metadata_keywords;

        $start_date = str_replace(['ص', 'م'], ['AM', 'PM'], $request->start_date);
        $end_date = str_replace(['ص', 'م'], ['AM', 'PM'], $request->end_date);

        $startDate = Carbon::createFromFormat('Y/m/d h:i A', $start_date)->format('Y-m-d H:i:s');
        $endDate = Carbon::createFromFormat('Y/m/d h:i A', $end_date)->format('Y-m-d H:i:s');

        $input['start_date']            = $startDate;
        $input['end_date']              = $endDate;

        $input['section']               =   3; // for event
        $input['status']                =   $request->status;
        $input['created_by']            =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $event = Event::create($input);

        $event->tags()->attach($request->tags);
        $event->users()->attach(Auth::user()->id);

        if ($request->hasFile('images') && count($request->images) > 0) {

            $i = $event->photos->count() + 1;
            $images = $request->file('images');
            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $event->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/events/' . $file_name));

                $event->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }


        if ($event) {
            return redirect()->route('admin.events.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.events.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_events')) {
            return redirect('admin/index');
        }
        return view('backend.events.show');
    }
    public function edit($event)
    {
        if (!auth()->user()->ability('admin', 'update_events')) {
            return redirect('admin/index');
        }
        $event = Event::where('id', $event)->first();
        $tags = Tag::whereStatus(1)->where('section', 3)->get(['id', 'name']);
        return view('backend.events.edit', compact('event', 'tags'));
    }

    public function update(EventRequest $request,  $event)
    {
        if (!auth()->user()->ability('admin', 'update_events')) {
            return redirect('admin/index');
        }
        $event = Event::where('id', $event)->first();

        $input['title']                 = $request->title;
        $input['content']               = $request->content;

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

        $start_date = str_replace(['ص', 'م'], ['AM', 'PM'], $request->start_date);
        $end_date = str_replace(['ص', 'م'], ['AM', 'PM'], $request->end_date);

        $startDate = Carbon::createFromFormat('Y/m/d h:i A', $start_date)->format('Y-m-d H:i:s');
        $endDate = Carbon::createFromFormat('Y/m/d h:i A', $end_date)->format('Y-m-d H:i:s');

        $input['start_date']            = $startDate;
        $input['end_date']              = $endDate;

        $input['section']               =   3; // for events
        $input['status']                =   $request->status;
        $input['created_by']            = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        $event->update($input);

        $event->tags()->sync($request->tags);

        $event->users()->attach(Auth::user()->id);


        if ($request->hasFile('images') && count($request->images) > 0) {
            $i = $event->photos->count() + 1;
            $images = $request->file('images');
            foreach ($images as $image) {
                $manager = new ImageManager(new Driver());

                $file_name = $event->slug . '_' . time() . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                $img = $manager->read($image);
                $img->save(base_path('public/assets/events/' . $file_name));

                $event->photos()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_status' => 'true',
                    'file_sort' => $i,
                ]);
                $i++;
            }
        }


        if ($event) {
            return redirect()->route('admin.events.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.events.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($event)
    {
        if (!auth()->user()->ability('admin', 'delete_events')) {
            return redirect('admin/index');
        }

        $event = Event::where('id', $event)->first();
        if ($event->photos->count() > 0) {
            foreach ($event->photos as $photo) {
                if (File::exists('assets/events/' . $photo->file_name)) {
                    unlink('assets/events/' . $photo->file_name);
                }
                $photo->delete();
            }
        }
        $event->delete();

        if ($event) {
            return redirect()->route('admin.events.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.events.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
    public function remove_image(Request $request)
    {
        if (!auth()->user()->ability('admin', 'delete_events')) {
            return redirect('admin/index');
        }
        $event = Event::findOrFail($request->course_id);
        $image = $event->photos()->where('id', $request->image_id)->first();
        if (File::exists('assets/events/' . $image->file_name)) {
            unlink('assets/events/' . $image->file_name);
        }
        $image->delete();
        return true;
    }

    public function updateEventStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Event::where('id', $data['event_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'event_id' => $data['event_id']]);
        }
    }
}
