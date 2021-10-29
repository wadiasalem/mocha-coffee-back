<?php

namespace App\Http\Controllers;

use App\Models\Category_Product;


class CategoryProductController extends Controller
{
    function getall(){

        return response()->json([
            'status' => 'success',
            'data'=>Category_Product::all()
        ],200);
    }
}
