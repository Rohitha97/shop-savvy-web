<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class APIUserController extends Controller
{
    use ResponseTrait;

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {
                return $this->errorResponse(data: $validator->errors()->all());
            }
            $user = User::getData(true)->whereIn('usertype', [3, 4])->where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $accessToken = $user->createToken('access_token')->plainTextToken;
                    return $this->successResponse(code: 200, data: ['user' => $user, 'access_token' => $accessToken]);
                } else {
                    return $this->errorResponse(code: 422, data: 'Credentials mismatch');
                }
            } else {
                return $this->errorResponse(code: 422, data: 'Credentials mismatch');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }


    public function register(Request $request)
    {
        $rules = [
            'name' => 'unique:users|required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ];

        $input = $request->only('name', 'email', 'password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->errorResponse(data: $validator->errors()->all());
        }
        $name = $request->name;
        $email    = $request->email;
        $password = $request->password;
        User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
        return $this->successResponse();
    }
}
