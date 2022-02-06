<?php

namespace App\Http\Controllers;

use App\Models\Category_Employer;
use App\Models\Commande;
use App\Models\Employer;
use App\Models\User;
use Carbon\Carbon;
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

        try{
            $user  = User::create($userData);
            $category = Category_Employer::where('name',$request->category)->first()->id;
            $Employer = [
                'user'=>$user->id,
                'name'=>$request->name,
                'category'=>$category,
                'phone'=>$request->phone,
                'cin'=>$request->cin,
                'birthday'=>$request->birthday,
            ];
            try{
                $employer =  Employer::create($Employer);
                return response()->json([
                    'status'=>'success',
                    'user' => $user,
                    'employer' => $employer
                ],200);
            }catch (\Illuminate\Database\QueryException $exception){
                $user->delete();
                return response()->json([
                    'status'=>'error',
                    'discription'=>'internal error in creating employer'
                ],404);
            }
        }catch (\Illuminate\Database\QueryException $exception){
            return response()->json([
                'status'=>'error',
                'discription'=>'internal error in creating user'
            ],404);
        }
        
    }

    function deleteEmployer(Request $request){
        $employer = Employer::find($request['id']);
        if(!is_null($employer)){
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

    function getEmployers(){
        $employer = Employer::get();
        if(count($employer)){
            return response()->json([
                'status'=>'success',
                'data'=>$employer
            ],200);
        }else{
            return response()->json([
                'status'=>'error',
                'description'=>'no employer find'
            ],404);
        }
    }

    function employerById(Request $request){
        $employer = Employer::find($request['id']);
        if(!is_null(count($employer))){
            $date = Carbon::now();
            $date->addHour(1);

            $commands = Commande::where('employer',$employer->id)->get();
            $today = Commande::where([
                ['employer',$employer->id],
                ['served_at','ILIKE',$date->format('Y-m-d').'%']
                ])->get();
                
            return response()->json([
                'status'=>'success',
                'employer' => $employer,
                'category' => $employer->getCategory,
                'data' => [
                    'today' => count($today),
                    'total' => count($commands)
                ]
            ]);
        }else{
            return response()->json([
                'status'=>'error',
                'discription'=>'There is no employer with this id'
            ],404);
        }
    }
}
