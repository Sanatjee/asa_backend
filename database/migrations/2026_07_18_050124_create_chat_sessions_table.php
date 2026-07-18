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
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum(
                'status',
                array_column(\App\Enums\ChatSessionStatus::cases(), 'value')
            )->default(\App\Enums\ChatSessionStatus::ACTIVE->value);
            
            $table->enum(
                'resolution_flag',
                array_column(\App\Enums\ChatSessionResolution::cases(), 'value')
            )->default(\App\Enums\ChatSessionResolution::UNRESOLVED->value);


            $table->timestamp('started_at');

            $table->timestamp('completed_at')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
    }
};
