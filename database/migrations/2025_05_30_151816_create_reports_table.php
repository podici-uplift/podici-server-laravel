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
        Schema::create('reports', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->ulidMorphs('reportable');

            $table->string('type'); // [ReportType]
            $table->string('title')->nullable();
            $table->text('report');

            $table->string('status')->default('pending');  // [ReportStatus]

            $table->dateTime('resolved_at')->nullable();
            $table->foreignUlid('resolved_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->tinyText('resolution_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
