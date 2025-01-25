<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FoodItem;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Support\Carbon;
use App\Models\Community;

class FoodItemSeeder extends Seeder
{
    public function run()
    {
        // Get test community id
        $communityId = Community::first()->id;

        if (Category::count() === 0 || Location::count() === 0) {
            $this->command->error("Es gibt keine Kategorien oder Standorte. Bitte zuerst CategorySeeder und LocationSeeder ausführen.");
            return;
        }

        $categories = Category::where('community_id', $communityId)->pluck('id')->toArray();
        $locations = Location::where('community_id', $communityId)->pluck('id')->toArray();

        FoodItem::create([
            'name' => 'Apples',
            'category_id' => $categories[array_rand($categories)],
            'location_id' => $locations[array_rand($locations)],
            'expiration_date' => Carbon::now()->addDays(7),
            'quantity' => 10,
            'community_id' => $communityId
        ]);

        FoodItem::create([
            'name' => 'Milk',
            'category_id' => $categories[array_rand($categories)],
            'location_id' => $locations[array_rand($locations)],
            'expiration_date' => Carbon::now()->addDays(3),
            'quantity' => 2,
            'community_id' => $communityId
        ]);

        FoodItem::create([
            'name' => 'Pasta',
            'category_id' => $categories[array_rand($categories)],
            'location_id' => $locations[array_rand($locations)],
            'expiration_date' => Carbon::now()->addDays(-1),
            'quantity' => 5,
            'community_id' => $communityId
        ]);

        $this->command->info("FoodItems erfolgreich befüllt!");
    }
}
