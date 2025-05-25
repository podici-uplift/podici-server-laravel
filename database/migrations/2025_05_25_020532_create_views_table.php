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
        Schema::create('views', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->nullableUlidMorphs('viewable');
            $table->foreignUlid('user_id');
            $table->date('viewed_at');
            $table->timestamps();

            $table->unique(['viewable_type', 'viewable_id', 'user_id', 'viewed_at'], 'unique_daily_view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('views');
    }
};
