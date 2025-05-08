<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $area = new Area();
        $area->name = 'Kreis';
        $area->slug = 'tomate';
        $area->description = 'Kreisförmige Area';
        $area->address = 'Kreisstrasse 1';
        $area->city = 'Berlin';
        $area->zip = '12345';
        $area->save();
    }
}
