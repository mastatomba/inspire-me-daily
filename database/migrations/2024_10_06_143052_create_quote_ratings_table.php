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
        Schema::create('quote_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('quote_id');
            $table->tinyInteger('rating');
            $table->timestamps();

            $table->unique(['user_id', 'quote_id']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('quote_id')->references('id')->on('quotes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_ratings');
    }
};
