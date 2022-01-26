<?php

namespace App\Http\Controllers;

use App\Models\Reword;
use Carbon\Carbon;
use Defuse\Crypto\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class RewordController extends Controller
{
    function addReword(Request $request){

        if($request->hasFile('image')){
            $file = $request->file('image');
            if($this->upload($file,$store)){
                try {
                    Reword::create([
                        'name' => $request['name'],
                        'description' => $request['description'],
                        'image' => $store,
                        'points' => $request['points'],
                        'date_start' => new Carbon($request['startSend'],'GMT+0'),
                        'date_end' =>  new Carbon($request['endSend'],'GMT+0')
                    ]);
                    return response()->json([
                        'status'=>true,
                        'description'=>'Reword added'
                    ],200);
                    
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
        $expiresAt = new \DateTime('tomorrow');
        $toDay = Carbon::now();
        $toDay->addHour(1);
        $rewords = Reword::where([['date_start','<',$toDay],['date_end','>',$toDay]])->get();
        $data = [];
        foreach ($rewords as $value) {
            $imageReference = app('firebase.storage')->getBucket()->object($value->image);  
            if($imageReference->exists()) { 
                $image = $imageReference->signedUrl($expiresAt); 
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

    function upload($image,&$store){
        $firebase_storage_path = 'rewords/';
        $fileName = pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
        $fileExt = $image->getClientOriginalExtension();
        $storeName = str_replace(' ','_',$fileName).'-'.rand().'-'.time().'.'.$fileExt; 
        $localfolder = public_path('firebase-temp-uploads') .'/';  
        if ($image->move($localfolder, $storeName)) {  
            $uploadedfile = fopen($localfolder.$storeName, 'r');  
            Firebase::storage()->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $storeName]);  
            //will remove from local laravel folder  
            unlink($localfolder . $storeName);
            $store = $firebase_storage_path . $storeName;
            return true;
        }else {
            return false;
        }

    }
}
