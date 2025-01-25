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
        // Test-Community erstellen
        $community = Community::create([
            'name' => 'Test Community',
            'code' => 'TEST123',
            'password' => Hash::make('password123')
        ]);

        // Test-User erstellen
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
        ]);

        // User mit der Community verknüpfen und Pivot-Daten setzen
        $user->communities()->attach($community->id, [
            'is_active' => true, // Aktive Community
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // Optional: current_community_id im User setzen
        $user->update(['current_community_id' => $community->id]);
    }
}
