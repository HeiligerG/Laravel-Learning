<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('bikes')->insert([
            [
                'name' => 'Fahrrad meines Bruders',
                'brand' => 'Velo de Ville',
                'description' => 'Ein robustes Stadtfahrrad mit Nabenschaltung, perfekt für tägliche Fahrten.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Fahrrad meiner Schwester',
                'brand' => 'Focus',
                'description' => 'Leichtes Mountainbike für Offroad-Abenteuer, mit Scheibenbremsen und Federung.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Fahrrad meines Vaters',
                'brand' => 'Canyon',
                'description' => 'Hochwertiges Rennrad mit Karbonrahmen, ideal für lange Touren auf Asphalt.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Fahrrad meiner Mutter',
                'brand' => 'Specialized',
                'description' => 'Komfortables E-Bike mit starkem Akku und guter Reichweite für Einkaufsfahrten.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mein Fahrrad',
                'brand' => 'Trek',
                'description' => 'Vielseitiges Gravel-Bike für Stadt und leichtes Gelände mit Schutzblechen.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}