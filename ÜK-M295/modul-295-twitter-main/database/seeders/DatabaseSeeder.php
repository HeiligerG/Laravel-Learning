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
            ->has(Tweet::factory()->count(rand(0, 50)))
            ->create();

        User::first()->update([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
    ]);
    }
}
