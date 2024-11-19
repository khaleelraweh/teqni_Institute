<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AdminInfoRequest;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slider;
use App\Models\User;
use App\Models\WebMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BackendController extends Controller
{
    public function login()
    {
        return view('backend.admin-login');
    }

    public function register()
    {
        return view('backend.admin-register');
    }

    public function lock_screen()
    {
        return view('backend.admin-lock-screen');
    }

    public function recover_password()
    {
        return view('backend.admin-recoverpw');
    }

    public function index()
    {
        $totalPosts = Post::where('section', 1)->count();
        $totalMainSliders = Slider::MainSliders()->count();
        $totalMainMenus = WebMenu::query()->where('section', 1)->count();
        $totalPages     = Page::count();
        $totalSupervisor = User::whereHas('roles', function ($query) {
            $query->where('name', 'supervisor');
        })->count();
        return view('backend.index', compact('totalPosts', 'totalMainSliders', 'totalPages', 'totalMainMenus', 'totalSupervisor'));
    }

    public function account_settings()
    {
        return view('backend.account_settings');
    }

    public function update_account_settings(AdminInfoRequest $request)
    {

        $user = auth()->user();
        $data['first_name'] =   $request->first_name;
        $data['last_name']  =   $request->last_name;
        $data['username']   =   $request->username;
        $data['email']      =   $request->email;
        $data['mobile']     =   $request->mobile;

        if (!empty($request->password) && !Hash::check($request->password, $user->password)) {
            $data['password'] = bcrypt($request->password);
        }

        if ($image = $request->file('user_image')) {

            if ($user->user_image != '') {
                if (File::exists('assets/users/' . $user->user_image)) {
                    unlink('assets/users/' . $user->user_image);
                }
            }

            $manager = new ImageManager(new Driver());
            $file_name = $user->username . '.' . $image->extension();
            $img = $manager->read($request->file('user_image'));
            $img->toJpeg(80)->save(base_path('public/assets/users/' . $file_name));
            $data['user_image'] = $file_name;
        }

        $user->update($data);

        // toast('Profile updated' , 'success');
        return back();
    }

    public function remove_image(Request $request)
    {

        $user = auth()->user();

        if ($user->user_image != '') {
            if (File::exists('assets/users/' . $user->user_image)) {
                unlink('assets/users/' . $user->user_image);
            }

            $user->user_image = null;
            $user->save();

            return true;
        }
    }


    public function create_update_theme(Request $request)
    {
        $theme = $request->input('theme_choice');

        if ($theme && in_array($theme, ['light', 'dark'])) {

            $cookie = cookie('theme', $theme, 60 * 25 * 365, "/"); // just one year
        }

        return back()->withCookie($cookie);
    }
}
