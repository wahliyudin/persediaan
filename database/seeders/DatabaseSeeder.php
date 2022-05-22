<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Type;
use App\Models\Unit;
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
        // \App\Models\User::factory(10)->create();
        Unit::factory(3)->create();
        Type::factory(10)->create();
        Product::factory(100)->create();
        $this->call(CreateRoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
