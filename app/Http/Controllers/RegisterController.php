<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RegisterController extends Controller
{

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|min:4:max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required',
            'password' => 'required|confirmed|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'gender' => 'required',
            'profile_image' => 'nullable'
        ]);

        //add to db
        $status = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'password'=>Hash::make($request->password),
                'gender'=>$request->gender,
                'profile_image'=>$request->profile_image
            ]);
        if($status){
            return response()->json(['message'=>'Registeration Successful']);
            return Redirect::to('/');
        }
        else{
            return response()->json(['message'=>'Registeration Unsuccessful']);
            return redirect()->back();
        }
    }

}
