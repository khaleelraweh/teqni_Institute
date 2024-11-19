<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\backend\InstructorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Role;
use App\Models\Specialization;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use illuminate\support\Str;

class InstructorController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_instructors , show_instructors')) {
            return redirect('admin/index');
        }

        //get users where has roles 
        $instructors = User::with('specializations')->whereHas('roles', function ($query) {
            //this roles its name is customer
            $query->where('name', 'instructor');
        })
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.instructors.index', compact('instructors'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_instructors')) {
            return redirect('admin/index');
        }
        $specializations = Specialization::get(['id', 'name']);
        return view('backend.instructors.create', compact('specializations'));
    }

    public function store(InstructorRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_instructors')) {
            return redirect('admin/index');
        }

        $input['first_name'] = $request->first_name;
        $input['last_name'] = $request->last_name;
        $input['username'] = $request->username;
        $input['email'] = $request->email;
        $input['email_verified_at'] = now();
        $input['mobile'] = $request->mobile;
        $input['password'] = bcrypt($request->password);

        $input['description'] = $request->description;
        $input['motavation'] = $request->motavation;
        $input['facebook'] = $request->facebook;
        $input['twitter'] = $request->twitter;
        $input['instagram'] = $request->instagram;
        $input['linkedin'] = $request->linkedin;

        $input['status'] = $request->status;
        $input['created_by'] = auth()->user()->full_name;

        if ($image = $request->file('user_image')) {


            $manager = new ImageManager(new Driver());
            $file_name = Str::slug($request->username) . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('user_image'));
            // $img = $img->resize(370, 246);

            $img->toJpeg(80)->save(base_path('public/assets/instructors/' . $file_name));

            $input['user_image'] = $file_name;
        }

        $instructor = User::create($input);

        //Attach the new instructor to role instructor
        $instructor->attachRole(Role::whereName('instructor')->first()->id);

        //add specifications
        if (isset($request->specializations) && count($request->specializations) > 0) {
            $instructor->specializations()->sync($request->specializations);
        }

        if ($instructor) {
            return redirect()->route('admin.instructors.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.instructors.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function show(User $instructor)
    {
        if (!auth()->user()->ability('admin', 'display_instructors')) {
            return redirect('admin/index');
        }
        return view('backend.instructors.show', compact('instructor'));
    }

    public function edit(User $instructor)
    {
        if (!auth()->user()->ability('admin', 'update_instructors')) {
            return redirect('admin/index');
        }

        $specializations = Specialization::get(['id', 'name']);

        $instructorSpecializations = $instructor->specializations->pluck(['id'])->toArray();

        return view('backend.instructors.edit', compact('instructor', 'specializations', 'instructorSpecializations'));
    }

    public function update(InstructorRequest $request, User $instructor)
    {
        if (!auth()->user()->ability('admin', 'update_instructors')) {
            return redirect('admin/index');
        }

        $input['first_name'] = $request->first_name;
        $input['last_name'] = $request->last_name;
        $input['username'] = $request->username;
        $input['email'] = $request->email;
        $input['mobile'] = $request->mobile;
        if (trim($request->password) != '') {
            $input['password'] = bcrypt($request->password);
        }

        $input['description'] = $request->description;
        $input['motavation'] = $request->motavation;
        $input['facebook'] = $request->facebook;
        $input['twitter'] = $request->twitter;
        $input['instagram'] = $request->instagram;
        $input['linkedin'] = $request->linkedin;


        $input['status'] = $request->status;
        $input['updated_by'] = auth()->user()->full_name;

        if ($image = $request->file('user_image')) {

            if ($instructor->user_image != null && File::exists('assets/instructors/' . $instructor->user_image)) {
                unlink('assets/instructors/' . $instructor->user_image);
            }

            $manager = new ImageManager(new Driver());
            $file_name = Str::slug($request->username) . '_' . time() .  "." . $image->getClientOriginalExtension();
            $img = $manager->read($request->file('user_image'));
            // $img = $img->resize(370, 246);
            $img->toJpeg(80)->save(base_path('public/assets/instructors/' . $file_name));


            $input['user_image'] = $file_name;
        }

        $instructor->update($input);

        //update specifications
        if (isset($request->specializations) && count($request->specializations) > 0) {
            $instructor->specializations()->sync($request->specializations);
        }

        if ($instructor) {
            return redirect()->route('admin.instructors.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.instructors.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function destroy(User $instructor)
    {
        if (!auth()->user()->ability('admin', 'delete_instructors')) {
            return redirect('admin/index');
        }

        // first: delete image from users path 
        if (File::exists('assets/instructors/' . $instructor->user_image)) {
            unlink('assets/instructors/' . $instructor->user_image);
        }

        $instructor->deleted_by = auth()->user()->full_name;
        $instructor->save();

        //second : delete customer from users table
        $instructor->delete();

        if ($instructor) {
            return redirect()->route('admin.instructors.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.instructors.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_instructors')) {
            return redirect('admin/index');
        }

        $instructor = User::findOrFail($request->instructor_id);
        if (File::exists('assets/instructors/' . $instructor->user_image)) {
            unlink('assets/instructors/' . $instructor->user_image);
            $instructor->user_image = null;
            $instructor->save();
        }
        if ($instructor->user_image != null) {
            $instructor->user_image = null;
            $instructor->save();
        }

        return true;
    }

    public function get_instructors()
    {
        //get user where has relation with roles and this role its name is customer
        $instructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })
            ->when(\request()->input('query') != '', function ($query) {
                $query->search(\request()->input('query'));
            })
            ->get(['id', 'first_name', 'last_name', 'email'])->toArray();

        return response()->json($instructors);
    }
}
