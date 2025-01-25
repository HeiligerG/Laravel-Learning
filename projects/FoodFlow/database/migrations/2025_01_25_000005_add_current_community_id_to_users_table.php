<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('current_community_id')
                ->nullable()
                ->constrained('communities')
                ->onDelete('set null');
        });
    }
};
