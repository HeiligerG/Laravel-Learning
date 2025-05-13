<?php

namespace Database\Seeders;
use App\Models\Tweet;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(20)
            ->has(Tweet::factory()->count(30))
            ->create();
    }
}
