<?php

namespace Database\Seeders;

use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = array(
            'email'=>'admin@coffee.com',
            'user_name'=>'admin',
            'password'=>bcrypt('admin'),
            'role'=>1
        );

        User::create($admin);

        $tab = array(
            array('x' => 20.50,'y' => 65.00),
            array('x' => 25.00,'y' => 60.50),
            array('x' => 30.00,'y' => 56.00),
            array('x' => 34.50,'y' => 51.50),
            array('x' => 39.50,'y' => 47.00),
            array('x' => 44.50,'y' => 42.50),
            array('x' => 60.00,'y' => 34.00),
            array('x' => 77.00,'y' => 55.00),
            array('x' => 55.00,'y' => 55.00),
            array('x' => 50.00,'y' => 83.00),
            array('x' => 66.00,'y' => 68.00),
            array('x' => 39.00,'y' => 70.00),
            array('x' => 49.50,'y' => 38.00)
          );
        
        for ($i=0; $i < 13; $i++) { 
            $table = "tab".$i+1;
            $user = User::create([
                'user_name'=>$table,
                'email'=>$table,
                'role'=>3,
                'password'=>bcrypt($table)
            ]);

            Table::create([
                'user'=>$user->id,
                'table_number'=>$i+1,
                'x'=>$tab[$i]['x'],
                'y'=>$tab[$i]['y']
            ]);
        }
    }
}
