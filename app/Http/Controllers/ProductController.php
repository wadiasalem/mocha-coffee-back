<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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
}
