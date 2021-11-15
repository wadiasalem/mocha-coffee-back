<?php

namespace Database\Seeders;

use App\Models\Category_Employer;
use Illuminate\Database\Seeder;

class Category_EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'waitress'],
            ['name' => 'delivery employer']
        ];

        foreach($data as $item)
        Category_Employer::create($item);
    }
}
