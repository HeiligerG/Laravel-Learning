<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('food_items')->truncate();
        DB::table('categories')->truncate();
        DB::table('locations')->truncate();


        $this->call(TestUserSeeder::class);
        $this->call(FoodItemSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(LocationSeeder::class);
    }
}
