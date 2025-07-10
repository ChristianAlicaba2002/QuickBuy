<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if($validator->fails())
        {
            return redirect()->route('admin_login_page')->with('error' , $validator->errors());
        }

        $user = Admin::where('email' , $request->email)->first();

        if(!$user || !Hash::check($request->password , $user->password))
        {
            return redirect()->route('admin_login_page')->with('error' , 'Account not found');
        }

        if(Auth::guard('admin')->attempt($request->only(['email','password'])))
        {
            $request->session()->regenerate();
            Auth::guard('admin');
            return redirect()->route('dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        
        return redirect()->route('admin_login_page');
    }

    
}
