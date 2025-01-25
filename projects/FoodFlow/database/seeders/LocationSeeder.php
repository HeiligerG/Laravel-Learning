<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\Community;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $communityId = Community::first()->id;

        $locations = [
            ['name' => 'Kühlschrank', 'community_id' => $communityId],
            ['name' => 'Keller', 'community_id' => $communityId],
            ['name' => 'Gefrierplatz', 'community_id' => $communityId],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
