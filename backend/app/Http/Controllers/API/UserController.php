<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function User(Request $request , User $user)
    {
        $Validator = Validator::make($request->all(),[
            'user_id' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'nullable|string',
            'city' => 'nullable|string',
            'barangay' => 'nullable|string',
            'purok' => 'nullable|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'nullable|string'
        ]);

        if($Validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => $Validator->errors()
            ]);
        }

        $user = User::create([
            "user_id" =>  $request->user_id,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "gender" => $request->gender,
            "city" => $request->city,
            "barangay" => $request->barangay,
            "purok" => $request->purok,
            "email" => $request->email,
            "password" => $request->password,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Register User Successfully',
            'data' => $user
        ]);
    }
}
