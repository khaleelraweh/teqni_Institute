<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PartnerRequest;
use App\Models\Partner;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use illuminate\support\Str;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class PartnerController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_partners , show_partners')) {
            return redirect('admin/index');
        }

        $partners = Partner::query()

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

        return view('backend.partners.index', compact('partners'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_partners')) {
            return redirect('admin/index');
        }
        return view('backend.partners.create');
    }


    public function store(PartnerRequest $request)
    {

        if (!auth()->user()->ability('admin', 'create_partners')) {
            return redirect('admin/index');
        }

        $input['name']                         =   $request->name;
        $input['description']                   =   $request->description;
        $input['partner_link']                   =   $request->partner_link;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->name[$localeKey] ?? null;
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

        $input['status']                        =   $request->status;
        $input['created_by']                    =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        // Handle file partner_image
        if ($partner_image = $request->file('partner_image')) {
            $manager        = new ImageManager(new Driver());
            $file_name      =   auth()->user()->id . '_partner_' . time() . '.' . $partner_image->extension();
            $img            = $manager->read($request->file('partner_image'));
            $img->save(base_path('public/assets/partners/' . $file_name));
            $input['partner_image'] = $file_name;
        }

        $partner                                 =  Partner::create($input);

        if ($partner) {
            return redirect()->route('admin.partners.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.partners.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function edit($partner)
    {

        if (!auth()->user()->ability('admin', 'update_partners')) {
            return redirect('admin/index');
        }

        $partner = Partner::where('id', $partner)->first();


        return view('backend.partners.edit', compact('partner'));
    }


    public function update(PartnerRequest $request, $partner)
    {
        if (!auth()->user()->ability('admin', 'update_partners')) {
            return redirect('admin/index');
        }

        $partner = Partner::where('id', $partner)->first();

        $input['name'] = $request->name;
        $input['description'] = $request->description;
        $input['partner_link']                   =   $request->partner_link;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->name[$localeKey] ?? null;
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

        $input['status'] = $request->status;
        $input['updated_by'] = auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;

        if ($image = $request->file('partner_image')) {
            if ($partner->partner_image != null && File::exists('assets/partners/' . $partner->partner_image)) {
                unlink('assets/partners/' . $partner->partner_image);
            }

            $manager = new ImageManager(new Driver());
            $file_name = Str::slug($request->username) . '_' . time() .  "." . $image->getClientOriginalExtension();
            $img = $manager->read($request->file('partner_image'));
            $img->save(base_path('public/assets/partners/' . $file_name));

            $input['partner_image'] = $file_name;
        }


        $partner->update($input);

        return redirect()->route('admin.partners.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }


    public function destroy($partner)
    {
        if (!auth()->user()->ability('admin', 'delete_partners')) {
            return redirect('admin/index');
        }

        $partner = Partner::where('id', $partner)->first();


        // first: delete image from users path 
        if ($partner->partner_image && File::exists('assets/partners/' . $partner->partner_image)) {
            unlink('assets/partners/' . $partner->partner_image);
        }

        $partner->deleted_by = auth()->user()->full_name;
        $partner->save();

        //second : delete partner from users table
        $partner->delete();

        return redirect()->route('admin.partners.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }


    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_partners')) {
            return redirect('admin/index');
        }

        $partner = Partner::findOrFail($request->partner_id);
        if (File::exists('assets/partners/' . $partner->partner_image)) {
            unlink('assets/partners/' . $partner->partner_image);
            $partner->partner_image = null;
            $partner->save();
        }
        if ($partner->partner_image != null) {
            $partner->partner_image = null;
            $partner->save();
        }

        return true;
    }

    public function updatePartnerStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Partner::where('id', $data['partner_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'partner_id' => $data['partner_id']]);
        }
    }
}
