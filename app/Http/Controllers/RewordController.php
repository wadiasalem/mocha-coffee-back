<?php

namespace App\Http\Controllers;

use App\Models\Reword;
use Carbon\Carbon;
use Defuse\Crypto\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RewordController extends Controller
{
    function addReword(Request $request){

        if($request->hasFile('image'))
        $file = $request->file('image');
        $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
        $fileExt = $file->getClientOriginalExtension();
        $storeName = str_replace(' ','_',$fileName).'-'.rand().'-'.time().'.'.$fileExt;
        $path = $file->storeAs('public/rewords',$storeName);
        if($path){
            
                $reword = Reword::create([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'image' => $path,
                    'points' => $request['points'],
                    'date_start' => new Carbon($request['startSend'],'GMT+0'),
                    'date_end' =>  new Carbon($request['endSend'],'GMT+0')
                ]);
                return response()->json([
                    'status'=>true,
                    'description'=>'Reword added'
                ],200);
                try {
            } catch (\Illuminate\Database\QueryException $exception) {
                return response()->json([
                    'status'=>false,
                    'description'=>'Reword creation error'
                ],400);
            }
            
        }else{
            return response()->json([
                'status'=>false,
                'description'=>'image creation error'
            ],400);
        }
        

    }

    function getRewordsAdmin(){
        $rewords = Reword::get();

        if(count($rewords)){
            return response()->json([
                'status'=>true,
                'rewords'=> $rewords
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'description'=>'0 Reword found'
            ],404);
        }
    }

    function getRewordsClient(){
        $toDay = Carbon::now();
        $toDay->addHour(1);
        $rewords = Reword::where([['date_start','<',$toDay],['date_end','>',$toDay]])->get();
        $data = [];
        foreach ($rewords as $value) {
            if (Storage::exists($value->image)) {
                $image = Storage::url($value->image);
                array_push($data,[
                    'reword'=>$value,
                    'image'=> $image,
                ]);
            }
        }
        if(count($data)){
            return response()->json([
                'status'=>true,
                'rewords'=> $data
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'description'=>'0 Reword found'
            ],404);
        }
    }
}
