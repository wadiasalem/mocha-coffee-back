<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Gift;
use App\Models\Product;
use App\Models\User;
use App\Models\Shop;
use App\Models\Shop_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShopController extends Controller
{
    function getGifts(){
        $idClient = User::find(Auth::user()->id)->getMoreDetails->id;
        $commandes = Shop::where('client',$idClient)->get();
        $data = [];
        foreach ($commandes as $value) {
            $detail = Shop_detail::where('shop',$value->id)->get();
            array_push($data, (object)[
                'command' => $value,
                'detail' => $detail
            ]);
        }
        return response()->json([
            'data'=> $data
        ]);
    }

    function shop(Request $request){
        $shop = Shop::create([
            'client'=> User::find(Auth::user()->id)->getMoreDetails->id
        ]);

        $detail = [];

        foreach ($request['cart'] as $value) {
            if($value){
                $product = Gift::find($value['id']);
                if($product->quantity>=$value['quantity']){
                    $product->update(['quantity'=>($product->quantity - $value['quantity'])]);
                    $item = Shop_detail::create([
                    'shop'=> $shop->id,
                    'gift' => $value['id'],
                    'quantity' => $value['quantity']
                ]);
                array_push($detail,$item);
                }else{
                    $shop->delete();
                    foreach ($detail as $value) {
                        $value->delete();
                    }
                    return response()->json([
                        'status'=>'error',
                        'description'=>'Error quantity'
                    ],404);
                }
                
            }
            
        }
        
        return response()->json([
            'status'=>'success',
            'description'=>'Shipping successfully'
        ],200);
        
    }
}
