<?php

use App\Enums\Review\ReviewStatus;
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
        Schema::create('reviews', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulidMorphs('reviewable');
            $table->foreignUlid('user_id')->constrained('users');
            $table->foreignUlid('parent_id')->nullable()->constrained('reviews');
            $table->string('title')->nullable();
            $table->text('review');
            $table->text('response')->nullable();
            $table->tinyInteger('rating')->nullable()->comment('over 10');
            $table->string('status', 48)->default(ReviewStatus::APPROVED->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
