<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AuthController extends Controller
{

    public function register(Request $request){
            // Validation rules
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|numeric|unique:users',
        'password' => 'required|string',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    // Validate the request data
    $validator = Validator::make($request->all(), $rules);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
        $data = $request->except('password','img',"cover_img" );

            $data['password'] = bcrypt($request->password);
            if ($request->hasFile('img')) {
                $data['img'] =UploadImage($request->file('img'),"users");
            }


        $user = User::create($data);
        $token = $user->createToken('tokens')->plainTextToken;
        $data = [
            'user' => new UserResource($user),
            'token'  => $token
        ];

        return sendResponse(200, 'user created successfully',$data);
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string',

        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

            $user = User::where('email' , $request->email)->first();
            if ($user && $user->is_active &&  Hash::check($request->password, $user->password)) {

                $token = $user->createToken('token')->plainTextToken;
                $data = [
                    'user' => new UserResource($user),
                    'token'  => $token
                ];

                return sendResponse(200, 'user login successfully',$data);
            }else{
                return sendResponse(403 ,'Email & Password does not match with our record.');
            }
    }


    public function update_profile(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'cover_img' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::find(auth()->user()->id);

        if ($user) {

            $data = $request->except('img',"cover_img");
            if ($request->hasFile('cover_img')) {
                if($user->cover_img){
                    Storage::delete($user->cover_img);
                    $data['cover_img'] = UploadImage($request->file('cover_img'),"users");
                }else{
                    $data['cover_img'] = UploadImage($request->file('cover_img'),"users");
                }
            }

            if ($request->hasFile('img')) {
                if($user->img){
                    Storage::delete($user->img);
                    $data['img'] = UploadImage($request->file('img'),"users");
                }else{
                    $data['img'] = UploadImage($request->file('img'),"users");
                }

            } else {
                $data['img'] = $user->img;
            }
            $user->update($data);

            return sendResponse( 200, 'user update successfully',new UserResource($user));
        }
    }


    public function get_profile()
    {

        $user = User::find(auth()->user()->id);
        if ($user) {
            return sendResponse(200, 'user found successfully',new UserResource($user) );
        } else {
            return notFoundResponse();
        }
    }


    public function change_Password(Request $request)
    {
        $rules = [
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = auth()->user();

        if ($user) {

            if (Hash::check($request->old_password, $user->password) ){
                $user->update(['password' => bcrypt($request->password)]);

                $user = User::find(auth()->user()->id);
                $token = $user->createToken('token')->plainTextToken;

                $data = [
                    'user' => new UserResource($user),
                    'token'  => $token
                ];

                return sendResponse(200, __('change_password_success'), $data);
            } else {

                return sendResponse(422, __('old_password_not_found'), );
            }
        } else {

            return sendResponse(404, __('token_not_found'), );
        } // end of else user

    } // end of change password

    public function delete_profile()
    {
        $user = User::find(auth()->user()->id);

        if ($user) {

            $user->delete();
            return sendResponse(200, 'account deleted successfully', );
        } else {
            return notFoundResponse();
        }
    }

    public function logout(Request $request)
    {
        $token =  $request->user()->tokens()->delete();
        return sendResponse(200, 'user logout successfully');
    }




}
