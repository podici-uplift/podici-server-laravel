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
        Schema::create('reviews', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulidMorphs('reviewable');
            $table->foreignUlid('reviewed_by')->constrained('users');
            $table->string('title')->nullable();
            $table->text('review');
            $table->text('response')->nullable();
            $table->tinyInteger('rating')->comment('over 10');
            $table->string('dispute_status')
                ->default('published')
                ->comment('The review can be disputted by the owner, but the rating would still count');
            $table->timestamp('disputed_at')->nullable();
            $table->timestamp('dispute_resolved_at')->nullable();
            $table->text('dispute_reason')->nullable();
            $table->text('admin_resolution_note')->nullable();
            $table->softDeletes();
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
