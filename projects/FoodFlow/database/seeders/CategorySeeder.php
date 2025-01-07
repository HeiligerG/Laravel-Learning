<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Frucht'],
            ['name' => 'Gemüse'],
            ['name' => 'Fleisch'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
