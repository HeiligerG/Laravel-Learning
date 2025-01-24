<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FoodItem;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Support\Carbon;

class FoodItemSeeder extends Seeder
{
    public function run()
    {
        // Prüfen, ob Kategorien und Standorte existieren
        if (Category::count() === 0 || Location::count() === 0) {
            $this->command->error("Es gibt keine Kategorien oder Standorte. Bitte zuerst CategorySeeder und LocationSeeder ausführen.");
            return;
        }

        // Existierende Kategorien und Standorte abrufen
        $categories = Category::pluck('id')->toArray();
        $locations = Location::pluck('id')->toArray();

        // Beispiel-Lebensmittel hinzufügen
        FoodItem::create([
            'name' => 'Apples',
            'category_id' => $categories[array_rand($categories)], // Zufällige Kategorie-ID
            'location_id' => $locations[array_rand($locations)], // Zufällige Standort-ID
            'expiration_date' => Carbon::now()->addDays(7), // Ablaufdatum in 7 Tagen
            'quantity' => 10,
        ]);

        FoodItem::create([
            'name' => 'Milk',
            'category_id' => $categories[array_rand($categories)],
            'location_id' => $locations[array_rand($locations)],
            'expiration_date' => Carbon::now()->addDays(3),
            'quantity' => 2,
        ]);

        FoodItem::create([
            'name' => 'Pasta',
            'category_id' => $categories[array_rand($categories)],
            'location_id' => $locations[array_rand($locations)],
            'expiration_date' => Carbon::now()->addDays(-1),
            'quantity' => 5,
        ]);

        $this->command->info("FoodItems erfolgreich befüllt!");
    }
}
