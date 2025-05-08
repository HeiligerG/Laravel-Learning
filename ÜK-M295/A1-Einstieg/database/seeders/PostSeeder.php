<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $now = '2023-04-05 16:44:45';

        Post::insert([
            [
                'title' => 'Tipp zum Glück',
                'content' => 'Denke an etwas, das dich glücklich macht.',
                'topic_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tipp für Beziehungen',
                'content' => 'Mach dir keine Sorgen, wenn du nicht die perfekte Beziehung hast. Es gibt auch keine perfekten Menschen.',
                'topic_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tipp für den Alltag',
                'content' => 'Wenn du dich schlecht fühlst, dann denke daran, dass es auch andere Menschen gibt, die sich schlecht fühlen.',
                'topic_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}