<?php

namespace App\Http\Controllers;

use App\Events\command;
use App\Mail\CommandDoneMail;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Commande_detail;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isNull;

class CommandeController extends Controller
{

    function getOrders(){
        $idClient = Auth::user()->getMoreDetails->id;
        $Orders = Commande::where('client',$idClient)->orderBy("id","desc")->get();
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
        $client = User::find(Auth::user()->id);
        $commande= Commande::create([
            'category'=>'delivery',
            'client'=> $client->getMoreDetails->id
        ]);

        $detail = [];

        foreach ($request['order'] as $value) {
            if($value){
                $product = Product::find($value['id']);
                if($product){
                    $item = Commande_detail::create([
                    'commande'=> $commande->id,
                    'product' => $value['id'],
                    'quantity'=>$value['quantity'],
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

        Mail::to($client->email)->send(new CommandDoneMail($detail,$client->name));
        
        return response()->json([
            'status'=>'success',
            'description'=>'Order successfully'
        ],200);
        
    }

    function buy(Request $request){
        $user = null ;
        if(!is_null($request->client['email']))
            $user = User::where('email',$request->client['email'])->first()->getMoreDetails->id;


        $commande= Commande::create([
            'category'=>'local',
            'table_id'=> User::find(Auth::user()->id)->getMoreDetails->id,
            'client' => $user
        ]);

        $detail = [];

        foreach ($request->order['items'] as $value) {
            if($value){
                $product = Product::find($value['id']);
                if($product){
                    $item = Commande_detail::create([
                    'commande'=> $commande->id,
                    'product' => $value['id'],
                    'quantity' => $value['quantity']
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
        ],200);
    }

    function getCommands_Employer(){
        $user_category = User::find(Auth::user()->id)->getMoreDetails->category ;
        if($user_category == 1){
            $commands = Commande::where('category','local')->get();
        }else{
            $commands = Commande::where('category','delivery')->get();
        }
        
        if($commands){
            $data = [];
            foreach ($commands as  $value) {
                array_push($data,[
                    'command' => $value,
                    'buyer' => $value->getBuyer,
                    'detail' => $value->getCommandDetails
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $data
            ],200);
        }else{
            return response()->json([
                'status' => 'error',
                'description' => 'no Command Found'
            ],404);
        }
        
    }


    function getStat_Employer(){
        $user = User::find(Auth::user()->id)->getMoreDetails->id ;
        $date = Carbon::now();
        $date->addHour(1);
        $commands = Commande::where('employer',$user)->get();

        $today = Commande::where([
            ['employer',$user],
            ['served_at','ILIKE',$date->format('Y-m-d').'%']
            ])->get();
        return response()->json([
            'status' => 'success',
            'data' => [
                'today' => count($today),
                'total' => count($commands)
            ]
            ]);
    }



    function command_action(Request $request){
        $commande = Commande::find($request->command);
        
        $employer = User::find(Auth::user()->id)->getMoreDetails->id ;
        $date = Carbon::now();
        $date->addHour(1);
        $old = $commande->category ;


        if($commande){
            if($old == "local" || $old == "delivery" ){
                $error = [];
                if($request->toDo != "canceled"){
                    $client = Client::find($commande->client) ;
                    $detail = $commande->getCommandDetails;
                    $points = 0 ;
                    foreach ($detail as $value) {
                        if($value->quantity > $value->getProduct->stock)
                        array_push($error,$value->getProduct);
                        else{
                            $value->getProduct->update([
                            'stock'=>($value->getProduct->stock - $value->quantity)
                            ]);
                            $points += 3*$value->quantity;
                        }
                    }
                    if(!is_null($client))
                        $client->update(['points'=>$client->points+$points]);
                }
                

                $commande->update([
                    'category'=> $request->toDo,
                    'employer' => $employer,
                    'served_at' => $date->format('Y-m-d H:m:s')
                ]);

                event(new command($commande->id,$old));
                return response()->json([
                    'status' => 'success',
                    'description' => 'Command '.$request->toDo,
                    'error'=>$error
                ],200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'description' => 'Command already '.$request->toDo
                ],404);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'description' => 'Command Not Found'
            ],404);
        }
    }
}
