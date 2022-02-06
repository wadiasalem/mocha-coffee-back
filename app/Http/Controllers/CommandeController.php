<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\CommandDoneMail;

use App\Events\command;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Commande_detail;
use App\Models\Product;
use App\Models\User;

use App\Services\Payment;

class CommandeController extends Controller
{

    function getOrders(){
        $idClient = Auth::user()->getMoreDetails->id;
        $Orders = Commande::where('client',$idClient)->orderBy("id","desc")->get();
        $data = [];
        if(count($Orders )){
            foreach ($Orders as $value) {
                $detail = Commande_detail::where('commande',$value->id)->get();
                array_push($data, (object)[
                    'order' => $value,
                    'detail' => $detail
                ]);
            }
            return response()->json([
                'status'=>true,
                'data'=> $data
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'description'=> "no commande found"
            ],404);
        }
    }

    function clientOrder(Request $request){

        $amount = $this->calculAmount($request['order']) ;

        $payment = new Payment();
        $payment->pay($request->payment,$amount);

        if($payment->hasError()){
            return response()->json([
                'status'=>false,
                'description'=>$payment->getError()
            ],400);
        }else{
            return $this->createCommande( 
                Auth::user(),
                $amount,
                $request['order'],
                'delivery');
        }
        

    }

    function tableOrder(Request $request){

        $client = null ;
        $amount = $this->calculAmount($request->order['items']) ;

        if(!is_null($request->client['email']))
            $client = User::where('email',$request->client['email'])->first();

        return $this->createCommande(
            $client,
            $amount,
            $request->order['items'],
            'local',
            Auth::user()->id->getMoreDetails->id,);

    }

    function getCommands_Employer(){
        $user_category = Auth::user()->getMoreDetails->getCategory ;
        if($user_category->name == 'waitress'){
            $commands = Commande::where('category','local')->get();
        }else{
            $commands = Commande::where('category','delivery')->get();
        }
        
        if(count($commands)){
            $data = [];
            foreach ($commands as  $value) {
                array_push($data,[
                    'command' => $value,
                    'buyer' => $value->getBuyer,
                    'detail' => $value->getCommandDetails
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => $data
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'description' => 'no Command Found'
            ],404);
        }
        
    }


    function getStat_Employer(){
        $user = Auth::user()->getMoreDetails->id ;
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
        
        if(!is_null($commande)){
            $employer = Auth::user()->getMoreDetails->id ;
            $date = Carbon::now();
            $date->addHour(1);
            $old = $commande->category ;
            if($old == "local" || $old == "delivery" ){
                if($request->toDo != "canceled"){
                    $client = Client::find($commande->client) ;
                    $detail = $commande->getCommandDetails;
                    $error = $this->addPoints($client,$detail);
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


    //cancel the commande 
    function cancelCommande(Commande $commande,array $detail){
        $commande->delete();
        foreach ($detail as $value) {
            $value->delete();
        }
    }

    //calculate and add points to the client 
    function addPoints(Client $client,array $detail){
        $points = 0 ;
        $error = [] ;
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

        return $error ;
    }

    //calculate the amount of command
    function calculAmount($commands){
        $amount = 0 ;
        foreach ($commands as $value) {
            if($value){
                $product = Product::find($value['id']);
                if($product){
                    $amount += $value['quantity']*$product->price;
                }
                
            }
            
        }
        return $amount ;
    }

    function createCommande(User $user,$amount = 0 , array $order,string $category ,$table = null ){
        $commande = Commande::create([
            'category'=>$category,
            'table_id'=>$table,
            'client'=> $user?->getMoreDetails->id,
            'amount'=>$amount
        ]);

        $detail = [];

        foreach ($order as $value) {
            if(!is_null($value)){
                $product = Product::find($value['id']);
                if(!is_null($product)){
                    $item = Commande_detail::create([
                    'commande'=> $commande->id,
                    'product' => $value['id'],
                    'quantity'=>$value['quantity'],
                    ]);
                    array_push($detail,$item);
                }else{
                    $this->cancelCommande($commande,$detail);
                    return response()->json([
                        'status'=>'error',
                        'description'=> $value['name'].' not exist'
                    ],404);
                }
                
            }
            
        }

        $user?->sendMail(new CommandDoneMail($detail,$user->getMoreDetails->name));
        
        return response()->json([
            'status'=>'success',
            'description'=>'Order successfully'
        ],200);
    }   
}
