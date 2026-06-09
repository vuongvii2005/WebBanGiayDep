<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE = 'payments';
    private const STATUS_OPTIONS = ['pending', 'completed', 'failed'];
    private const DEFAULT_STATUS = 'pending';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('status', self::STATUS_OPTIONS)->default(self::DEFAULT_STATUS);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
