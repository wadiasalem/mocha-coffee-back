<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'=>'admin'],
            ['name'=>'client'],
            ['name'=>'table'],
            ['name'=>'employer'],
        ];
        foreach($data as $item)
        Role::create($item);
    }
}
