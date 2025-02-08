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

        if (!$user) {
            abort(403, "Kein Benutzer eingeloggt.");
        }

        $unseenPatchNotes = $user->unseenPatchNotes()->latest('release_date')->take(1)->get();

        return view('patch-notes.show', compact('unseenPatchNotes'));
    }


    public function markAsSeen()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Bitte melde dich an, um die neuesten Änderungen zu sehen.'], 403);
        }

        $latestPatchNote = $user->patchNotes()
            ->wherePivot('seen', false)
            ->latest('release_date')
            ->first();

        if ($latestPatchNote) {
            $user->patchNotes()->updateExistingPivot($latestPatchNote->id, ['seen' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Danke, dass du auf dem neuesten Stand bleibst, ' . $user->name . '! 😊'
        ]);
    }

}
