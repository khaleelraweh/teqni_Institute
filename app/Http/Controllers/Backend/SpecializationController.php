<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SpecializationRequest;
use App\Models\Specialization;
use DateTimeImmutable;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_specializations , show_specializations')) {
            return redirect('admin/index');
        }

        $specializations = Specialization::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.specializations.index', compact('specializations'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_specializations')) {
            return redirect('admin/index');
        }
        return view('backend.specializations.create');
    }

    public function store(SpecializationRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_specializations')) {
            return redirect('admin/index');
        }

        $input['name']          =   $request->name;
        $input['status']        =   $request->status;
        $input['created_by']    =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $specialization = Specialization::create($input);

        if ($specialization) {
            return redirect()->route('admin.specializations.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.specializations.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_specializations')) {
            return redirect('admin/index');
        }
        return view('backend.specializations.show');
    }

    public function edit($specialization)
    {
        if (!auth()->user()->ability('admin', 'update_specializations')) {
            return redirect('admin/index');
        }

        $specialization = Specialization::where('id', $specialization)->first();

        return view('backend.specializations.edit', compact('specialization'));
    }

    public function update(SpecializationRequest $request,  $specialization)
    {
        if (!auth()->user()->ability('admin', 'update_specializations')) {
            return redirect('admin/index');
        }

        $specialization = Specialization::where('id', $specialization)->first();

        $input['name'] = $request->name;
        $input['status']        =   $request->status;
        $input['updated_by']    =   auth()->user()->full_name;

        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        $specialization->update($input);

        if ($specialization) {
            return redirect()->route('admin.specializations.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('admin.specializations.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($specialization)
    {
        if (!auth()->user()->ability('admin', 'delete_specializations')) {
            return redirect('admin/index');
        }

        $specialization = Specialization::where('id', $specialization)->first();
        $specialization->delete();


        if ($specialization) {
            return redirect()->route('admin.specializations.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.specializations.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
