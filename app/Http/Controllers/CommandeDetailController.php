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

        $period = array('today','month','year');

        $date = Carbon::now();
        $date->addHours(1);
        $data = [
            'today' =>0,
            'month' =>0,
            'year' =>0
        ];

        for ($i=0; $i < 3; $i++) { 
            $format = substr("Y-m-d", 0, 5 - $i*2);
            $data = Commande_detail::where('created_at','ILIKE',$date->format($format).'%')->get();
            $data[$period[$i]]  = $this->calcultIncom($data);
        }

        return response()->json([
            'status'=>true,
            'data'=>$data,
        ]);
    }

    function calcultIncom($commands){
        $result = 0 ;
        foreach ($commands as $value) {
            $category = $value->getCommand->category;
            if($category == 'served' || $category == 'delivered')
            $result += ($value->quantity * $value->getProduct->price);
        }
        return $result ;
    }
}
