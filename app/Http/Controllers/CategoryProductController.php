<?php

namespace App\Http\Controllers;

use App\Models\Category_Product;

use function PHPUnit\Framework\isEmpty;

class CategoryProductController extends Controller
{
    function get_menu(){

        $productes = Category_Product::all();
        if(count($productes))
            return response()->json([
                'status' => 'success',
                'data'=>$productes,
            ],200);
        else
            return response()->json([
                'status' => 'error',
                'description'=>'no data found'
            ],200);
    }
}
