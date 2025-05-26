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
        Schema::create('monthly_views', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulidMorphs('viewable');
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->unsignedInteger('views')->default(1);

            $table->unique(['viewable_type', 'viewable_id', 'year', 'month'], 'monthly_views_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_views');
    }
};
