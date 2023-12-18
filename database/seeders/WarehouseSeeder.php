<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Warehouse;
use App\Models\WarehouseLocation;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Structure:
         * Warehouse:
         * Receiving Area
         * Packing Area
         * Storage Area:
         * Aisle
         * Row
         * Level
         * Place
         * 
         * We will create a warehouse with 3 zones: Receiving, Packing, Storage
         * Storage will have 6 aisles, each aisle will have 6 rows, each row will have 4 levels, each level will have 5 places
         */
        $w = Warehouse::create([
            'name' => 'Main Warehouse',
            'code' => 'w1',
        ]);

        $r = WarehouseLocation::create([
            'name' => 'Receiving Area',
            'code' => 'receiv1',
            'warehouse_id' => $w->id,
        ]);

        $p = WarehouseLocation::create([
            'name' => 'Packing Area',
            'code' => 'pack1',
            'warehouse_id' => $w->id,
        ]);

        $s = WarehouseLocation::create([
            'name' => 'Storage Area',
            'code' => 'stor1',
            'warehouse_id' => $w->id,
        ]);

        for ($a = 1; $a <= 6; $a++) {
            $aisle = WarehouseLocation::create([
                'name' => 'Aisle ' . $a,
                'code' => 'aisle' . $a,
                'warehouse_id' => $w->id,
                'parent_id' => $s->id,
            ]);

            for ($r = 1; $r <= 6; $r++) {
                $row = WarehouseLocation::create([
                    'name' => 'Row ' . $r,
                    'code' => 'row' . $r,
                    'warehouse_id' => $w->id,
                    'parent_id' => $aisle->id,
                ]);

                for ($l = 1; $l <= 4; $l++) {
                    $level = WarehouseLocation::create([
                        'name' => 'Level ' . $l,
                        'code' => 'level' . $l,
                        'warehouse_id' => $w->id,
                        'parent_id' => $row->id,
                    ]);

                    for ($p = 1; $p <= 5; $p++) {
                        WarehouseLocation::create([
                            'name' => 'Place ' . $p,
                            'code' => 'place' . $p,
                            'warehouse_id' => $w->id,
                            'parent_id' => $level->id,
                        ]);
                    }
                }
            }
        }

    }
}
