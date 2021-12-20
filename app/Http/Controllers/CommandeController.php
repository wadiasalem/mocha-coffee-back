<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Commande_detail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{

    function getOrders(){
        $idClient = User::find(Auth::user()->id)->getMoreDetails->id;
        $Orders = Commande::where('client',$idClient)->get();
        $data = [];
        foreach ($Orders as $value) {
            $detail = Commande_detail::where('commande',$value->id)->get();
            array_push($data, (object)[
                'order' => $value,
                'detail' => $detail
            ]);
        }
        return response()->json([
            'data'=> $data
        ]);
    }

    function clientOrder(Request $request){
        $commande= Commande::create([
            'category'=>'delivery',
            'client'=> User::find(Auth::user()->id)->getMoreDetails->id
        ]);

        $detail = [];

        foreach ($request['order'] as $value) {
            if($value){
                $product = Product::find($value['id']);
                if($product){
                    $item = Commande_detail::create([
                    'commande'=> $commande->id,
                    'product' => $value['id'],
                ]);
                array_push($detail,$item);
                }else{
                    $commande->delete();
                    foreach ($detail as $value) {
                        $value->delete();
                    }
                    return response()->json([
                        'status'=>'error',
                        'description'=> $value['name'].' not exist'
                    ],404);
                }
                
            }
            
        }
        
        return response()->json([
            'status'=>'success',
            'description'=>'Order successfully'
        ],200);
        
    }

    function buy(Request $request){
        $commande= Commande::create([
            'category'=>'local',
            'table_id'=> User::find(Auth::user()->id)->getMoreDetails->id
        ]);

        $detail = [];

        foreach ($request->items as $value) {
            if($value){
                $product = Product::find($value['id']);
                if($product){
                    $item = Commande_detail::create([
                    'commande'=> $commande->id,
                    'product' => $value['id'],
                ]);
                array_push($detail,$item);
                }else{
                    $commande->delete();
                    foreach ($detail as $value) {
                        $value->delete();
                    }
                    return response()->json([
                        'status'=>'error',
                        'description'=> $value['name'].' not exist'
                    ],404);
                }
                
            }
            
        }

        return response()->json([
            'status'=>'success',
            'description'=>'Order successfully',
            '1'=>$commande,
            '2'=>$detail
        ],200);
    }
}
