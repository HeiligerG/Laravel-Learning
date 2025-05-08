<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $now = '2023-04-05 16:44:45';

        // 1. Post: Tipp zum Glück
        $post1 = Post::create([
            'title' => 'Tipp zum Glück',
            'content' => 'Denke an etwas, das dich glücklich macht.',
            'topic_id' => 1,
            'author_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $post1->tags()->attach(
            Tag::whereIn('slug', ['spruch', 'tipp'])->pluck('id')
        );

        // 2. Post: Tipp für Beziehungen
        $post2 = Post::create([
            'title' => 'Tipp für Beziehungen',
            'content' => 'Mach dir keine Sorgen, wenn du nicht die perfekte Beziehung hast. Es gibt auch keine perfekten Menschen.',
            'topic_id' => 2,
            'author_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $post2->tags()->attach(
            Tag::whereIn('slug', ['beziehung'])->pluck('id')
        );

        // 3. Post: Tipp für den Alltag
        $post3 = Post::create([
            'title' => 'Tipp für den Alltag',
            'content' => 'Wenn du dich schlecht fühlst, dann denke daran, dass es auch andere Menschen gibt, die sich schlecht fühlen.',
            'topic_id' => 3,
            'author_id' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $post3->tags()->attach(
            Tag::whereIn('slug', ['spruch'])->pluck('id')
        );
    }
}