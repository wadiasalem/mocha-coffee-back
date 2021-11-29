<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use ArrayObject;
use Illuminate\Http\Request;

class GiftController extends Controller
{


    function get_gifts_byId(Request $request){
        $result = [];
        foreach ($request->gifts as $value) {
            array_push($result,Gift::find($value['gift']));
        }

        if(count($result)){
            return response()->json([
                'status'=>'success',
                'gifts'=>$result
            ],200);
        }else
        return response()->json([
            'status'=>'success',
            'description'=>'no data found'
        ],404);
        
    }

    function get_gifts(){

        $gifts = Gift::all();
        if(count($gifts))
            return response()->json([
                'status' => 'success',
                'data'=>$gifts,
            ],200);
        else
            return response()->json([
                'status' => 'error',
                'description'=>'no data found'
            ],200);
    }


    function get_gifts_filter(Request $request){

        $gifts = Gift::where('name','like','%'.$request->name.'%')
            ->havingBetween('price',[$request->min,$request->max])
            ->orderBy($request->sort,$request->by)
            ->get();
            
        

        if(count($gifts))
            return response()->json([
                'status' => 'success',
                'data'=>$gifts,
            ],200);
        else
            return response()->json([
                'status' => 'error',
                'description'=>'no data found'
            ],200);
    }
    
}
