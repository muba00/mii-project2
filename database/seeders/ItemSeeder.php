<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Using a loop to add 20 items
        for ($i = 1; $i <= 20; $i++) {
            Item::create([
                'name' => 'Item ' . $i,
                'gtin' => '1234567890' . $i,
                'weight' => rand(300, 1000), // Random weight between 300 and 1000 grams
            ]);
        }
    }
}
