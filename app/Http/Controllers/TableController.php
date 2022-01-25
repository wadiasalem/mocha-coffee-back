<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Commande_detail;
use App\Models\Employer;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TableController extends Controller
{

    function getTables(){
        $tables = Table::get();
        if(count($tables)){
            return response()->json([
                'status'=>'success',
                'tables'=>$tables
            ],200);
        }else{
            return response()->json([
                'status'=>'error',
                'description'=>'no table find'
            ],404);
        }
    }


    function createTable(Request $request){
        $userData = [
            'user_name'=>$request->user_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role' => 3
        ];

        if (Table::where('table_number',$request->table_number)->first())
            return response()->json([
                'status'=>'error',
                'discription'=>'Table number already exist'
            ],404);


        $user  = User::create($userData);

        if($user){
            $tableData = [
                'user'=>$user->id,
                'table_number'=>$request->table_number
            ];
            $table =  Table::create($tableData);
            if($table){
                return response()->json([
                    'status'=>'success',
                    'user' => $user,
                    'table' => $table
                ],200);
            }else{
                $user ->delete();
                return response()->json([
                    'status'=>'error',
                    'discription'=>'internal error in creating table'
                ],404);
            }
        }else{
            return response()->json([
                'status'=>'error',
                'discription'=>'internal error in creating user'
            ],404);
        }
    }

    function deleteTable(Request $request){
        $table = Table::where('table_number',$request->table_number)->get();
        if($table){
            $user =User::find($table->user);
            $table->delete();
            $user->delete();
            return response()->json([
                'status'=>'success',
                'description'=>'table Deleted'
            ],200);
        }else{
            return response()->json([
                'status'=>'error',
                'description'=>'no table find with this number'
            ],404);
        }
    }

    function updatePassword(Request $request){
        $table = Table::where('table_number',$request->table_number)->get();
        if($table){
            $user =User::find($table->user);
            $user->update(['password'=> Hash::make($request->newPassword)]);
            return response()->json([
                'status'=>'success',
                'description'=>'table updated'
            ],200);
        }else{
            return response()->json([
                'status'=>'error',
                'description'=>'no table find with this number'
            ],404);
        }
    }

    function tableInformation(Request $request){
        $table = Table::where('table_number',$request->table_number)->first();
        if (is_null($table))
            return response()->json([
                'status'=>'error',
                'discription'=>'There is no table with this number'
            ],404);

        $date = Carbon::now();

        $commandes = Commande::where([
            ['table_id','=',$table->id],
            ['created_at','like',$date->format('Y-m-d').'%']
            ])->get();

        $data = [] ;
        $dayTotal = 0 ;
        foreach ($commandes as $value ) {
            $detail = Commande_detail::where('commande',$value->id)->get();
            $total = 0 ;
            $detailData = [] ;
            foreach ($detail as $det) {
                $product = Product::find($det->product);
                array_push($detailData,[
                    'product' => $product->name,
                    'quantity' => $det->quantity
                ]);
                $total +=  $product->price * $det->quantity;
            }
            $employer = Employer::find($value->employer)?->name;
            array_push($data,['commande'=>$value,'detaill'=>$detailData,'total'=>$total,'employer'=>$employer]);
            if($value->category == 'served')
            $dayTotal += $total ;
        }

        $reservations = DB::select(
            'select * from reservations where table_id = ? and date_end >= ?',
            [$table->id,$date->format('Y-m-d h:m:s')]);

        $reservationsDate = [];
        foreach ($reservations as  $value) {
            $client = Client::find($value->client) ;
            $table = Table::find($value->table_id) ;
            array_push($reservationsDate,[
                'data' => [
                    'id' => $value->id,
                    'client' => $value->client,
                    'normal' => $value->normal,
                    'child' => $value->child,
                    'date_start' => $value->date_start,
                    'date_end' => $value->date_end,
                    
                ],
                'client' => [
                    'name' => $client->name,
                    'phone' => $client->phone,
                ] ,
                'table' => $table->table_number
            ]);
        }

        return response()->json([
            'reservations'=>$reservationsDate,
            'commandeData'=>$data,
            'toDayInCome'=>$dayTotal
        ],200);
    }

    function getReservations(){
        $date = Carbon::now();
        $date->addHour(1);
        $reservations = DB::select(
            'select * from reservations where date_start >= ?',
            [$date->format('Y-m-d h:m:s')]);
        
            $reservationsDate = [];
            foreach ($reservations as  $value) {
                $client = Client::find($value->client) ;
                $table = Table::find($value->table_id) ;
                array_push($reservationsDate,[
                    'data' => [
                        'id' => $value->id,
                        'client' => $value->client,
                        'normal' => $value->normal,
                        'child' => $value->child,
                        'date_start' => $value->date_start,
                        'date_end' => $value->date_end,
                        
                    ],
                    'client' => [
                        'name' => $client->name,
                        'phone' => $client->phone,
                    ] ,
                    'table' => $table->table_number
                ]);
            }
        
        if(count($reservationsDate)){
            return response()->json([
                'status' => 'success',
                'reservations' => $reservationsDate
            ],200);
        }else{
            return response()->json([
                'status' => 'error',
                'description' => 'No Reservation Found'
            ],404);
        }

    }


    function logoutCheck(Request $request){
        if(!Hash::check( $request->password , Auth::user()->password))
            return response()->json([
                'status'=>'error',
                'description'=>'password invalid'
            ],404);
        else{
            return response()->json([
                'status'=>'success',
                'description'=>'password valid'
            ],200);
        }
    }
}
