<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE = 'support_tickets';
    private const STATUS_OPTIONS = ['open', 'in_progress', 'resolved', 'closed'];
    private const DEFAULT_STATUS = 'open';
    private const PRIORITY_OPTIONS = ['low', 'medium', 'high', 'urgent'];
    private const DEFAULT_PRIORITY = 'medium';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('subject');
            $table->longText('description');
            $table->enum('status', self::STATUS_OPTIONS)->default(self::DEFAULT_STATUS);
            $table->enum('priority', self::PRIORITY_OPTIONS)->default(self::DEFAULT_PRIORITY);
            $table->string('category')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('status');
            $table->index('priority');
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
