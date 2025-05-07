<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'title' => 'Clean Code',
            'author' => 'Robert C. Martin',
            'slug' => 'clean-code',
            'year' => 2008,
            'pages' => 464,
            'created_at' => '2023-04-05 10:00:00',
            'updated_at' => '2023-04-05 12:00:00',
        ]);

        Book::create([
            'title' => 'Finanzfluss – Der Weg zur finanziellen Freiheit',
            'author' => 'Thomas Kehl & Mona Linke',
            'slug' => 'finanzfluss',
            'year' => 2022,
            'pages' => 320,
            'created_at' => '2023-04-05 10:00:00',
            'updated_at' => '2023-04-05 12:00:00',
        ]);

        Book::create([
            'title' => 'Per Anhalter durch die Galaxis',
            'author' => 'Douglas Adams',
            'slug' => 'per-anhalter-durch-die-galaxis',
            'year' => 1979,
            'pages' => 208,
            'created_at' => '2023-04-05 10:00:00',
            'updated_at' => '2023-04-05 12:00:00',
        ]);
    }
}