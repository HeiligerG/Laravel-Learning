<?php

namespace Database\Seeders;

use App\Models\PatchNote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatchNotesSeeder extends Seeder
{
    public function run()
    {
        $patches = [
            [
                'version' => '1.1.0',
                'description' => "- Neue Suchfunktion implementiert\n- Performance optimiert\n- UI verbessert",
                'release_date' => '2025-01-26'
            ],
            // Neue Patches hier hinzufügen
        ];

        foreach ($patches as $patch) {
            PatchNote::updateOrCreate(
                ['version' => $patch['version']],
                $patch
            );
        }
    }
}
