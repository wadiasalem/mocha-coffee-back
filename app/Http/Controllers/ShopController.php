<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Gift;
use App\Models\User;
use App\Models\Shop;
use App\Models\Shop_detail;

use App\Services\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShopController extends Controller
{
    function getGifts(){
        $idClient = Auth::user()->getMoreDetails->id;
        $commandes = Shop::where('client',$idClient)->orderBy("id","desc")->get();
        $data = [];
        foreach ($commandes as $value) {
            $detail = Shop_detail::where('shop',$value->id)->get();
            array_push($data, (object)[
                'command' => $value,
                'detail' => $detail
            ]);
        }
        return response()->json([
            'status'=>true,
            'data'=> $data
        ]);
    }

    function shop(Request $request){
        $amount = $this->calculAmount($request['cart'] ) ;
        
        $payment = new Payment();
        $payment->pay($request->payment,$amount);

        if($payment->hasError()){
            return response()->json([
                'status'=>false,
                'description'=>$payment->getError()
            ],400);
        }

        try{
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
                        $this->cancelCommande($shop , $detail);
                        return response()->json([
                            'status'=>'error',
                            'description'=>'Error quantity'
                        ],404);
                    }
                    
                }
                
            }
            
            return response()->json([
                'status'=>true,
                'description'=>'Shipping successfully'
            ],200);
        }catch(QueryException $exception){
            return response()->json([
                'status'=>false,
                'description'=>'internal error'
            ],200);
        }
        
        
    }

    //cancel the commande 
    function cancelCommande(Shop $shop,array $detail){
        $shop->delete();
        foreach ($detail as $value) {
            $value->delete();
        }
    }

    //calculate the amount of command
    function calculAmount($commands){
        $amount = 0 ;
        foreach ($commands as $value) {
            if($value){
                $product = Gift::find($value['id']);
                if($product){
                    $amount += $value['quantity']*$product->price;
                }
                
            }
            
        }
        return $amount ;
    }
}
