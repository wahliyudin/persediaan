<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouses = [
            [
                'name'=>'Gudang 1'
            ],
            [
                'name'=>'Gudang 2'
            ],
            [
                'name'=>'Gudang 3'
            ]
        ];
        foreach ($warehouses as $item) {
            Warehouse::create($item);
        }
    }
}
