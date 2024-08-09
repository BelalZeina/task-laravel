<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class LoginController extends Controller
{

    public function register()
    {
        return view('website.user.auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric',
            'password' => 'required|string|confirmed',
            'agree_to_terms' => 'required'
        ]);

        $data = $request->except('password','img',"cover_img" );

        $data['password'] = bcrypt($request->password);
        if ($request->hasFile('img')) {
            $data['img'] =UploadImage($request->file('img'),"users");
        }
        if ($request->hasFile('cover_img')) {
            $data['cover_img'] =UploadImage($request->file('cover_img'),"users");
        }

        $user = User::create($data);
        // Attempt to log in admin
        if (auth()->login($user)) {
            return redirect()->intended(route('home'))->with('success', 'تم تسجيل الدخول بنجاح');
        }

    }
    public function create()
    {
        return view('website.user.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in admin
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended(route('home'))->with('success', 'تم تسجيل الدخول بنجاح');
        }

        // Neither admin nor regular user authenticated
        return redirect()->back()->withInput($request->only('password'))->withErrors([
            'password' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',
        ]);
    }


    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('user.login');
    }






}
