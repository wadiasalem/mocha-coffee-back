<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    function information_update(Request $request){
        if(!Hash::check( $request->password , Auth::user()->password))
            return response()->json([
                'status'=>'error',
                'description'=>'invalid password'
            ],404);
        else{
            if(Client::where([
                ['phone',$request['number']],
                ['id','<>',User::find(Auth::user()->id)->getMoreDetails->id]
                ])->get()->count()>0)
                return response()->json([
                    'status'=>'error',
                    'description'=>'Phone number already taken'
                ],404);

            $update = [
                'name'  => $request->name,
                'phone' => $request->number,
                'address' => $request->address,
            ];
            Client::find(User::find(Auth::user()->id)->getMoreDetails->id)->update($update);

            return response()->json([
                'status'=>'success',
                'description'=>'update successfully'
            ],200);
        }
    }

    function add_point(){
        
    }

    function getPoints(){
        $client = Auth::user()->getMoreDetails->points ;
        return response()->json([
            'status'=>true,
            'points'=>$client
        ]);
    }
}
