<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patch_notes', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->text('description');
            $table->date('release_date');
            $table->timestamps();
        });

        Schema::create('user_patch_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patch_note_id')->constrained()->cascadeOnDelete();
            $table->boolean('seen')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_patch_notes');
        Schema::dropIfExists('patch_notes');
    }
};
