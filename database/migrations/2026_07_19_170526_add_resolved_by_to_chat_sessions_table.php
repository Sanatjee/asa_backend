<?php

use App\Enums\ChatSessionResolutionBy;
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
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->enum(
                'resolved_by',
                array_column(ChatSessionResolutionBy::cases(), 'value')
            )
            ->nullable()
            ->after('resolution_flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            //
        });
    }
};
