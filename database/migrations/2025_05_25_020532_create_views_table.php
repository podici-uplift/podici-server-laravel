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
            $table->ulidMorphs('viewable');
            $table->foreignUlid('viewed_by')->constrained('users');
            $table->date('date');

            $table->unique(['viewable_type', 'viewable_id', 'viewed_by', 'date'], 'views_unique');
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
