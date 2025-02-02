<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatchNote;
use App\Models\User;

class PatchNoteController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $unseenPatchNotes = $user->unseenPatchNotes()->get();
        return view('patch-notes.show', compact('unseenPatchNotes'));
    }

    public function markAsSeen(PatchNote $patchNote)
    {
        $user = auth()->user();
        $user->patchNotes()->syncWithoutDetaching([
            $patchNote->id => ['seen' => true]
        ]);

        return response()->json(['success' => true]);
    }
}
