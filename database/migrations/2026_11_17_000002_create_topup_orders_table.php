<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Order top up game. Statusnya demo saja: tidak ada payment
// gateway, order cukup dicatat lalu tampil di halaman Akun.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('top_up_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('game');
            $table->integer('nominal');
            $table->string('game_user_id');
            $table->string('status')->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('top_up_orders');
    }
};
