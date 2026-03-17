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
        Schema::create('payments', static function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique()->index();
            $table->string('status', 64);
            $table->unsignedBigInteger('amount');
            $table->dateTimeTz('event_time')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
