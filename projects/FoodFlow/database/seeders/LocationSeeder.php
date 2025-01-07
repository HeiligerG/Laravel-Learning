<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            ['name' => 'Kühlschrank'],
            ['name' => 'Keller'],
            ['name' => 'Gefrierplatz'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
