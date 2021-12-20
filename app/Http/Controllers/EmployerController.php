<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployerController extends Controller
{
    function createEmployer(Request $request){
        $userData = [
            'user_name'=>$request->user_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role' => 4
        ];

        $user  = User::create($userData);

        if($user){
            $Employer = [
                'user'=>$user->id,
                'name'=>$request->name,
                'category'=>$request->category,
                'phone'=>$request->phone,
                'cin'=>$request->cin,
                'birthday'=>$request->birthday,
            ];
            $employer =  Employer::create($Employer);
            if($employer){
                return response()->json([
                    'status'=>'success',
                    'user' => $user,
                    'employer' => $employer
                ],200);
            }else{
                $user->delete();
                return response()->json([
                    'status'=>'error',
                    'discription'=>'internal error in creating employer'
                ],404);
            }
        }else{
            return response()->json([
                'status'=>'error',
                'discription'=>'internal error in creating user'
            ],404);
        }
    }

    function deleteTable(Request $request){
        $employer = Employer::find($request->employer_Id);
        if($employer){
            $user =User::find($employer->user);
            $employer->delete();
            $user->delete();
            return response()->json([
                'status'=>'success',
                'description'=>'employer Deleted'
            ],200);
        }else{
            return response()->json([
                'status'=>'error',
                'description'=>'no employer find with this number'
            ],404);
        }
    }
}
