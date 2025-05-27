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
        Schema::create('products', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('shop_id')->constrained('shops');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('long_description')->nullable();
            $table->text('owner_notes')->nullable()->comment('Owner notes for the product. NOT displayed to users');
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable()->comment('Sale price for the product');
            $table->string('currency');
            $table->integer('quantity_left')->nullable();
            $table->boolean('is_adult')->default(false);
            $table->boolean('is_listed')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('flag')->nullable(); // [FlagStatus]
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
