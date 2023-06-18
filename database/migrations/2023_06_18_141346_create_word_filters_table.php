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
        Schema::create('word_filters', function (Blueprint $table) {
            $table->id();

            $table->longText('word')->nullable();
            $table->string('type')->nullable();

            $table->foreign('telegram_user_id')
                ->references('id')
                ->on('telegram_users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_filters');
    }
};
