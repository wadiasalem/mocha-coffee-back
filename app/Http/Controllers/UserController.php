<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function password_update(Request $request){
        if(!$request->newPassword == $request->confirmPassword)
            return response()->json([
                'status'=>'error',
                'description'=>'new password not much'
            ],404);
        elseif(!Hash::check( $request->oldPassword , Auth::user()->password))
            return response()->json([
                'status'=>'error',
                'description'=>'password invalid'
            ],404);
        else{
            User::find(Auth::user()->id)->update(['password'=> Hash::make($request->newPassword)]);
            return response()->json([
                'status'=>'success',
                'description'=>'password changed'
            ],200);
        }
    }

}
