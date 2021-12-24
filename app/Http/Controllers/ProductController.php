<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\JsonDecoder;

use function PHPUnit\Framework\isNull;

class ProductController extends Controller
{
    function get_orders_byId(Request $request){
        $result = [];
        foreach ($request->order as $value) {
            array_push($result,Product::find($value['product']));
        }

        if(count($result)){
            return response()->json([
                'status'=>'success',
                'products'=>$result
            ],200);
        }else
        return response()->json([
            'status'=>'success',
            'description'=>'no data found'
        ],404);
    }

    function get_product_category(Request $request){
        $data = Product::where('category',$request->id)
            ->get();
        if(count($data))
            return response()->json([
                'status' => 'success',
                'data'=>$data,
            ],200);
        else
            return response()->json([
                'status' => 'error',
                'description'=>'no data found'
            ],200);
    }

    function getProducts_Employer(Request $request){
        $detail= [] ;
        foreach ($request->items as $value) {
            
            $product = Product::find($value['product']) ;
            array_push($detail,[
                'product' => $product,
                'quantity' => $value['quantity']
            ]);
        }

        return response()->json([
            'status' => 'success',
            'products' => $detail
        ],200);
    }

    function getProductStock(){
        $products = Product::all();
        if(count($products))
            return response()->json([
                'status' => 'success',
                'products'=>$products,
            ],200);
        else
            return response()->json([
                'status' => 'error',
                'description'=>'no data found'
            ],200);
    }

    function updateProduct(Request $request){
        $product = Product::find($request->id);
        if($product){
            $product->update([
                $request->toDo => $request->value
            ]);

            return response()->json([
                'status' => 'success',
                'description' => 'Update Done',
            ],200);
        }else{
            return response()->json([
                'status' => 'error',
                'description' => 'Product Not Found'
            ],404);
        }
    }
}
