<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Community;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $communityId = Community::first()->id;

        $categories = [
            ['name' => 'Frucht', 'community_id' => $communityId],
            ['name' => 'Gemüse', 'community_id' => $communityId],
            ['name' => 'Fleisch', 'community_id' => $communityId],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
