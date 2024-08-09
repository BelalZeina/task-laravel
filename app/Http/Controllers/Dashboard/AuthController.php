<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use App\Repositories\Sql\AdminRepository;
use Illuminate\Http\Request;


class AuthController extends Controller
{

    public function create()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in admin
        if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended(route('dashboard.index'))->with('success', 'تم تسجيل الدخول بنجاح');
        }

        // Neither admin nor regular user authenticated
        return redirect()->back()->withInput($request->only('password'))->withErrors([
            'password' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',
        ]);
    }


    public function logout(Request $request)
    {
        auth('admin')->logout();
        return redirect()->route('login');
    }

    public function setting()
    {
        $data = Admin::find(auth("admin")->id());
        return view("dashboard.admins.setting", compact("data"));
    }


    public function update_setting(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:8',
        ]);
        $admin =Admin::find(auth("admin")->id());
        $data = $request->except('password', 'img');

        $data['password'] = $request->password ? bcrypt($request->password) : $admin->password;

        if ($request->hasFile('img')) {
            $data['img'] = UploadImage($request->file('img'), "users");
        }
        $admin->update($data);
        return redirect()->back()->with('success', __('models.edited_successfully'));
    }




}
