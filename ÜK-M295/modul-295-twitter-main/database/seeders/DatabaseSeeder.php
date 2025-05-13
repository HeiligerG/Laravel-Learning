<?php

namespace Database\Seeders;
use App\Models\Tweet;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Tweet::factory()->count(200)->create();
    }
}
