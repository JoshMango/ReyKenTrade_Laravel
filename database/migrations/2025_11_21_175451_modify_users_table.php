<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Users table already modified in create_users_table migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
