<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Plant;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plant::all()->each(function (Plant $plant) {
            Area::factory()->count(rand(1, 10))->create([
                'plant_id' => $plant->id,
            ]);
        });
    }
}
