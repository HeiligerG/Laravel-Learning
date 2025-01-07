<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FoodItemsSeeder extends Seeder
{
    public function run()
    {
        DB::table('food_items')->insert([
            [
                'name' => 'Apples',
                'category' => 'Fruits',
                'location' => 'Refrigerator',
                'expiration_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Milk',
                'category' => 'Dairy',
                'location' => 'Refrigerator',
                'expiration_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pasta',
                'category' => 'Grains',
                'location' => 'Pantry',
                'expiration_date' => Carbon::now()->addMonths(12)->format('Y-m-d'),
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
