<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Paket top up per game: order menyimpan label paket yang dipilih
// ("85 Diamond") di kolom paket; nominal tetap menyimpan harga paket
// dalam rupiah. Game tanpa paket terverifikasi memakai kolom paket
// NULL dan nominal seperti sebelumnya.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('top_up_orders', function (Blueprint $table) {
            $table->string('paket')->nullable()->after('game');
        });
    }

    public function down(): void
    {
        Schema::table('top_up_orders', function (Blueprint $table) {
            $table->dropColumn('paket');
        });
    }
};
