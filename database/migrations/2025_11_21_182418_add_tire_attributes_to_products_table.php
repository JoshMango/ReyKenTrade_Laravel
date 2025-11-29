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
        Schema::table('productdata', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('productName');
            $table->string('size')->nullable()->after('brand');
            $table->string('type')->nullable()->after('size'); // e.g., All-Season, All-Terrain, Performance, etc.
            $table->integer('load_index')->nullable()->after('type');
            $table->string('speed_rating')->nullable()->after('load_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productdata', function (Blueprint $table) {
            $table->dropColumn(['brand', 'size', 'type', 'load_index', 'speed_rating']);
        });
    }
};
