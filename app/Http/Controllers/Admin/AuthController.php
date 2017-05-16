<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('auth.profile');
    }

    public function changePassword(){
        return view('auth.passwords.change');
    }

    public function postCredentials(Request $request)
    {
        if(Auth::Check())
        {
            $this->validate($request, [
                'current_password' => 'required',
                'password' => 'required|same:password',
                'confirm_password' => 'required|same:password',
            ]);

            $request_data = $request->all();

            $current_password = Auth::user()->password;
            if(Hash::check($request_data['current_password'], $current_password))
            {
                $user_id = Auth::user()->id;
                $obj_user = Admin::find($user_id);
                $obj_user->password = Hash::make($request_data['password']);
                $obj_user->save();
                return redirect()->route('password.change')
                    ->with('success','Change Password Successfully');
            }
            else
            {
                return redirect()->route('password.change')->with('error','Please enter correct current password');
            }
        }
        else
        {
            return redirect()->to('/');
        }
    }

}
