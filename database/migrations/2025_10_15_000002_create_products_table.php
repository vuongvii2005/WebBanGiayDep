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
        Schema::create('webnc_products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable()->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // Multiple images
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->integer('stock')->default(0);
            $table->string('size')->nullable(); // e.g., "36,37,38,39,40"
            $table->string('color')->nullable();
            $table->string('brand')->nullable(); // Thuong hieu
            $table->string('material')->nullable(); // Chat lieu
            $table->text('specifications')->nullable(); // Thong so ky thuat
            $table->decimal('rating', 3, 2)->default(0); // Danh gia (0-5)
            $table->integer('reviews_count')->default(0); // So luong danh gia
            $table->integer('views_count')->default(0); // So luot xem
            $table->integer('sales_count')->default(0); // So luong ban
            $table->text('warranty')->nullable(); // Bao hanh
            $table->text('care_instructions')->nullable(); // Huong dan bao quan
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webnc_products');
    }
};
