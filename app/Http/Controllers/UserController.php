<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function password_update(Request $request){
        if(!$request->new_password == $request->confirm_new_password)
            return response()->json([
                'status'=>'error',
                'description'=>'new password not much'
            ],404);
        elseif(!Hash::check( $request->password , Auth::user()->password))
            return response()->json([
                'status'=>'error',
                'description'=>'password invalid'
            ],404);
        else{
            User::find(Auth::user()->id)->update(['password'=> Hash::make($request->new_password)]);
            return response()->json([
                'status'=>'success',
                'description'=>'password changed'
            ],200);
        }
    }

}
