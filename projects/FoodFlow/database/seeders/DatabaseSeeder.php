<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('communities')->truncate();
        DB::table('community_user')->truncate();
        DB::table('categories')->truncate();
        DB::table('locations')->truncate();
        DB::table('food_items')->truncate();
        DB::table('patch_notes')->truncate();
        DB::table('user_patch_notes')->truncate();

        $this->call(TestUserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(FoodItemSeeder::class);
        $this->call(PatchNotesSeeder::class);
    }
}
