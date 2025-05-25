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
        Schema::create('daily_views', function (Blueprint $table) {
            $table->ulidMorphs('viewable');
            $table->date('date');
            $table->unsignedInteger('views')->default(1);

            $table->unique(['viewable_type', 'viewable_id', 'date'], 'daily_views_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_views');
    }
};
