<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        Tag::insert([
            ['name' => 'Spruch', 'slug' => 'spruch'],
            ['name' => 'Tipp', 'slug' => 'tipp'],
            ['name' => 'Beziehung', 'slug' => 'beziehung'],
        ]);
    }
}