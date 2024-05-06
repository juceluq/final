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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reserva_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('establishment_id');
            $table->integer('rating');
            $table->text('comment');
            $table->dateTime('review_date');
            $table->timestamps();

            $table->foreign('reserva_id')->constrained()->onDelete('cascade');
            $table->foreign('user_id')->constrained()->onDelete('cascade');
            $table->foreign('establishment_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
