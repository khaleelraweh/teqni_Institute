<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StatisticRequest;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class StatisticsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_statistics , show_statistics')) {
            return redirect('admin/index');
        }

        $statistics = Statistic::query()
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


        return view('backend.statistics.index', compact('statistics'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_statistics')) {
            return redirect('admin/index');
        }

        return view('backend.statistics.create');
    }

    public function store(StatisticRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_statistics')) {
            return redirect('admin/index');
        }

        $input['icon']                      =   $request->icon;
        $input['title']                     =   $request->title;
        $input['statistic_number']          =   $request->statistic_number;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description']  = $request->metadata_description;
        $input['metadata_keywords']     = $request->metadata_keywords;

        $input['status']                    =   $request->status;
        $input['created_by']                =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        // Save album profile 
        if ($image = $request->file('statistic_image')) {
            $manager = new ImageManager(new Driver());
            $file_name = 'album' . time() . '.' . $image->extension();
            $img = $manager->read($request->file('statistic_image'));
            $img->toJpeg(80)->save(base_path('public/assets/statistics/' . $file_name));
            $input['statistic_image'] = $file_name;
        }

        $statistic = Statistic::create($input);

        if ($statistic) {
            return redirect()->route('admin.statistics.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.statistics.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_statistics')) {
            return redirect('admin/index');
        }

        return view('backend.statistics.show');
    }

    public function edit($statistic)
    {
        if (!auth()->user()->ability('admin', 'update_statistics')) {
            return redirect('admin/index');
        }

        $statistic =  Statistic::where('id', $statistic)->first();
        return view('backend.statistics.edit', compact('statistic'));
    }

    public function update(StatisticRequest $request,  $statistic)
    {
        if (!auth()->user()->ability('admin', 'update_statistics')) {
            return redirect('admin/index');
        }

        $statistic = Statistic::where('id', $statistic)->first();

        $input['icon']                      =   $request->icon;
        $input['title']                     =   $request->title;
        $input['statistic_number']          =   $request->statistic_number;

        $input['metadata_title'] = [];
        foreach (config('locales.languages') as $localeKey => $localeValue) {
            $input['metadata_title'][$localeKey] = $request->metadata_title[$localeKey]
                ?: $request->title[$localeKey] ?? null;
        }
        $input['metadata_description']  = $request->metadata_description;
        $input['metadata_keywords']     = $request->metadata_keywords;

        $input['status']                    =   $request->status;
        $input['created_by']                =   auth()->user()->full_name;

        $published_on = str_replace(['ص', 'م'], ['AM', 'PM'], $request->published_on);
        $publishedOn = Carbon::createFromFormat('Y/m/d h:i A', $published_on)->format('Y-m-d H:i:s');
        $input['published_on']            = $publishedOn;


        // Save album profile 
        if ($statisticImage = $request->file('statistic_image')) {

            if (File::exists('assets/statistics/' . $statisticImage)) {
                unlink('assets/statistics/' . $statisticImage);
            }

            $manager = new ImageManager(new Driver());
            $file_name = 'statistics' . time() . '.' . $statisticImage->extension();
            $img = $manager->read($request->file('statistic_image'));
            $img->toJpeg(80)->save(base_path('public/assets/statistics/' . $file_name));
            $input['statistic_image'] = $file_name;
        }

        $statistic->update($input);




        if ($statistic) {
            return redirect()->route('admin.statistics.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.statistics.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($statistic)
    {
        if (!auth()->user()->ability('admin', 'delete_statistics')) {
            return redirect('admin/index');
        }

        $statistic = Statistic::where('id', $statistic)->first();

        $statistic->delete();

        if ($statistic) {
            return redirect()->route('admin.statistics.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.statistics.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_statistic_image(Request $request)
    {
        $statistic = Statistic::findOrFail($request->statistic_id);

        if ($statistic->statistic_image != '') {
            if (File::exists('assets/statistics/' . $statistic->statistic_image)) {
                unlink('assets/statistics/' . $statistic->statistic_image);
            }

            $statistic->statistic_image = null;
            $statistic->save();

            return true;
        }
    }

    public function updateStatisticStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Statistic::where('id', $data['statistic_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'statistic_id' => $data['statistic_id']]);
        }
    }
}
