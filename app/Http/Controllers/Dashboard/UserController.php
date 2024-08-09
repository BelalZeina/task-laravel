<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $data = User::get();
        return view("dashboard.users.index", compact("data"));
    }


    public function create()
    {
        return view("dashboard.users.create");

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required|string|min:8',
            'img' => 'nullable|image',
        ]);
        $data = $request->except('password', 'img');

        $data['password'] = bcrypt($request->password);

        if ($request->hasFile('img')) {
            $data['img'] = UploadImage($request->file('img'), "images");
        }

        $user = User::create($data);

        return redirect(route('users.index'))->with('success', __('models.added_successfully'));
    }


    public function show($id)
    {
        $data = User::find($id);
        return view("dashboard.users.show", compact("data"));
    }


    public function edit($id)
    {
        $data = User::find($id);
        return view("dashboard.users.edit", compact("data"));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:8',
        ]);
        $user = User::find($id);
        $data = $request->except('password', 'img');

        $data['password'] = $request->password ? bcrypt($request->password) : $user->password;

        if ($request->hasFile('img')) {
            $data['img'] = UploadImage($request->file('img'), "users");
        }
        $user->update($data);
        return redirect(route('users.index'))->with('success', __('models.edited_successfully'));
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect(route('users.index'))->with('success', __('models.deleted_successfully'));

    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        // return response()->json(['success' => true ,"ids"=> $ids]);
        foreach ($ids as $id) {
            $user = User::find($id);
            if ($user) {
                $user->delete();
            }
        }
        return response()->json(['success' => true]);
    }
    public function toggleActivation(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json(['success' => true, 'is_active' => $user->is_active]);
    }


}
