<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Community;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
        ]);

        // Create test community
        $community = Community::create([
            'name' => 'Test Community',
            'code' => 'TEST123',
            'password' => Hash::make('password123')
        ]);

        // Attach user to community
        $user->communities()->attach($community->id);
    }
}
