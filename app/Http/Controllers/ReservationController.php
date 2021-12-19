<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    function getReservations(Request $request){
        $reservations = DB::select('
        select * from reservations where date_start <= ? 
        and date_end >= ?
        ', [$request->date,$request->date]);

        $tables = [] ;

        foreach ($reservations as $value) {
            $tab = Table::find($value->table_id);
            array_push($tables,$tab->table_number);
        }

        return response()->json([
            'status' => 'success',
            'reservations' => $tables
        ],200);
        
    }

    function reserve(Request $request){
        
        $date_start = new Carbon($request->date,'GMT+0');
        $date_end = new Carbon($request->date,'GMT+0');
        $date_end ->add(1,'hour');
        $client = User::find(Auth::user()->id)->getMoreDetails; 

        foreach ($request->table as $value) {
            $table = Table::where('table_number',$value)->first();
            
            
            DB::insert('insert into reservations (client, table_id,normal,child,date_start,date_end) values (?,?,?, ?,?,?)', 
            [
                $client->id,
                $table->id,
                $request->normal,
                $request->child,
                $date_start,
                $date_end
            ]);
            
            
        }

        return response()->json([
            'status' => 'success',
            'discription' => 'Reservation successfuly'
        ],200);
    }

}
