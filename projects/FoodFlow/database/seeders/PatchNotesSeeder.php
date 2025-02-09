<?php

namespace Database\Seeders;

use App\Models\PatchNote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class PatchNotesSeeder extends Seeder
{
    public function run()
    {
        $patches = [
            [
                'version' => '1.1.0',
                'description' => "- Fehlerbehebung\n- Suchfunktion\n- Clean Alerts\n- Filterung\n- Responsive Design",
                'release_date' => '2025-02-09'
            ],
        ];

        foreach ($patches as $patchData) {
            $patch = PatchNote::create($patchData);

            $users = User::all();
            foreach ($users as $user) {
                $user->patchNotes()->attach($patch->id, ['seen' => false]);
            }
        }
    }
}
