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
        Schema::create('review_flags', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('review_id')->constrained('reviews');
            $table->foreignUlid('user_id')->nullable()->constrained('users');
            $table->string('type', 48);
            $table->integer('submissions')->default(1);
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['review_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_flags');
    }
};
