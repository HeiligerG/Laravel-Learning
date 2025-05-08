<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plant;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plant = new Plant();
        $plant->name = 'Tomate';
        $plant->slug = 'tomate';
        $plant->description = 'Tomaten sind Früchte der Tomatenpflanze.';
        $plant->stock = 10;
        $plant->area_id = 1;
        $plant->save();
    }
}
