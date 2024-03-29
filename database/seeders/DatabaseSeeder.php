<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Category_EmployerSeeder::class,
            Category_productSeed::class,
            ProductesSeed::class,
            RoleSeed::class,
            GiftSeed::class,
            UserSeed::class
        ]);
    }
}
