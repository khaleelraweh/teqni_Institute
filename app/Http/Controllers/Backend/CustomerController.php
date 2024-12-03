<?php

namespace App\Http\Controllers\Backend;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use illuminate\support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CustomerRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_customers , show_customers')) {
            return redirect('admin/index');
        }

        //get users where has roles 
        $customers = User::whereHas('roles', function ($query) {
            //this roles its name is customer
            $query->where('name', 'customer');
        })
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);

        return view('backend.customers.index', compact('customers'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_customers')) {
            return redirect('admin/index');
        }
        return view('backend.customers.create');
    }

    public function store(CustomerRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_customers')) {
            return redirect('admin/index');
        }

        $input['first_name'] = $request->first_name;
        $input['last_name'] = $request->last_name;
        $input['username'] = $request->username;
        $input['email'] = $request->email;
        $input['email_verified_at'] = now();
        $input['mobile'] = $request->mobile;
        $input['password'] = bcrypt($request->password);
        $input['status'] = $request->status;
        $input['created_by'] = auth()->user()->full_name;


        if ($image = $request->file('user_image')) {

            $manager = new ImageManager(new Driver());
            $file_name = Str::slug($request->username) . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('user_image'));
            // $img = $img->resize(370, 246);

            $img->toJpeg(80)->save(base_path('public/assets/customers/' . $file_name));

            // $path = public_path('assets/customers/' . $file_name);

            // Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($path, 100);

            $input['user_image'] = $file_name;
        }

        $customer = User::create($input);

        //Attach the new customer to role customer
        $customer->attachRole(Role::whereName('customer')->first()->id);

        return redirect()->route('admin.customers.index')->with([
            'message' => 'created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show(User $customer)
    {
        if (!auth()->user()->ability('admin', 'display_customers')) {
            return redirect('admin/index');
        }
        return view('backend.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        if (!auth()->user()->ability('admin', 'update_customers')) {
            return redirect('admin/index');
        }

        return view('backend.customers.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, User $customer)
    {
        if (!auth()->user()->ability('admin', 'update_customers')) {
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
        $input['status'] = $request->status;
        $input['updated_by'] = auth()->user()->full_name;

        if ($image = $request->file('user_image')) {
            if ($customer->user_image != null && File::exists('assets/customers/' . $customer->user_image)) {
                unlink('assets/customers/' . $customer->user_image);
            }

            $manager = new ImageManager(new Driver());
            $file_name = Str::slug($request->username) . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('user_image'));
            // $img = $img->resize(370, 246);

            $img->toJpeg(80)->save(base_path('public/assets/customers/' . $file_name));

            $input['user_image'] = $file_name;
        }

        $customer->update($input);

        return redirect()->route('admin.customers.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(User $customer)
    {
        if (!auth()->user()->ability('admin', 'delete_customers')) {
            return redirect('admin/index');
        }

        // first: delete image from users path 
        if (File::exists('assets/customers/' . $customer->user_image)) {
            unlink('assets/customers/' . $customer->user_image);
        }

        $customer->deleted_by = auth()->user()->full_name;
        $customer->save();

        //second : delete customer from users table
        $customer->delete();

        return redirect()->route('admin.customers.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_customers')) {
            return redirect('admin/index');
        }

        $customer = User::findOrFail($request->customer_id);
        if (File::exists('assets/customers/' . $customer->user_image)) {
            unlink('assets/customers/' . $customer->user_image);
            $customer->user_image = null;
            $customer->save();
        }
        if ($customer->user_image != null) {
            $customer->user_image = null;
            $customer->save();
        }

        return true;
    }

    public function get_customers()
    {
        //get user where has relation with roles and this role its name is customer
        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })
            ->when(\request()->input('query') != '', function ($query) {
                $query->search(\request()->input('query'));
            })
            ->get(['id', 'first_name', 'last_name', 'email'])->toArray();

        return response()->json($customers);
    }
}
