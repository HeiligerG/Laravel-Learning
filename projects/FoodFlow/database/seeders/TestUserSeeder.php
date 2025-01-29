<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Community;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $community = Community::create([
            'name' => 'Test Community',
            'code' => 'TEST123',
            'password' => Hash::make('password123')
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
        ]);

        $user->communities()->attach($community->id, [
            'is_active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $user->update(['current_community_id' => $community->id]);
    }
}
