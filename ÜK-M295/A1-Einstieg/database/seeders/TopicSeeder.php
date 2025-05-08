<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $now = '2023-04-05 16:44:45';

        Topic::insert([
            [
                'id' => 1,
                'name' => 'Glück',
                'slug' => 'glueck',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Beziehung',
                'slug' => 'beziehung',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Alltag',
                'slug' => 'alltag',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}