<?php

namespace App\Http\Controllers;

use App\Models\Commande_detail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommandeDetailController extends Controller
{
    function getDetail(Request $request){
        $detail = Commande_detail::where('commande',$request->command)->get();
        return response()->json([
            'detail' => $detail
        ],200);
    }

    function InComeStat(){

        $date = Carbon::now();
        $date->addHours(1);
        $data = [
            'today' =>0,
            'month' =>0,
            'year' =>0
        ];

        $today = Commande_detail::where('created_at','like',$date->format('Y-m-d').'%')->get();
        foreach ($today as $value) {
            $category = $value->getCommand->category;
            if($category == 'served' || $category == 'delivered')
            $data['today'] += ($value->quantity * $value->getProduct->price);
        }

        $month = Commande_detail::where('created_at','like',$date->format('Y-m').'%')->get();
        foreach ($month as $value) {
            $category = $value->getCommand->category;
            if($category == 'served' || $category == 'delivered')
            $data['month'] += ($value->quantity * $value->getProduct->price);
        }

        $year = Commande_detail::where('created_at','like',$date->format('Y').'%')->get();
        foreach ($year as $value) {
            $category = $value->getCommand->category;
            if($category == 'served' || $category == 'delivered')
            $data['year'] += ($value->quantity * $value->getProduct->price);
        }

        return response()->json([
            'status'=>true,
            'data'=>$data,
        ]);
    }
}
