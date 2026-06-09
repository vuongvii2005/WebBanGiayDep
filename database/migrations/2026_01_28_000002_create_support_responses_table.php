<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE = 'support_responses';
    private const TICKET_TABLE = 'support_tickets';
    private const USERS_TABLE = 'users';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_ticket_id')->constrained(self::TICKET_TABLE)->onDelete('cascade');
            $table->foreignId('user_id')->constrained(self::USERS_TABLE)->onDelete('cascade');
            $table->longText('response_text');
            $table->boolean('is_admin_response')->default(false);
            $table->timestamps();
            $table->index('support_ticket_id');
            $table->index('user_id');
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
