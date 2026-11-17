<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Struktur tabel products — cerminan create_programs_table di PPT,
// kolomnya disesuaikan dengan dataset kanonis TriverseStore (DATASET.md).
// Penjual disimpan sebagai kolom biasa (seller_nama, seller_rating,
// seller_penjualan, seller_kota): Sprint 07 hanya membahas satu
// model/tabel, relasi antar tabel masuk materi berikutnya.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('judul');
            $table->string('game');
            $table->string('kategori');
            $table->string('seller_nama');
            $table->decimal('seller_rating', 2, 1);
            $table->integer('seller_penjualan');
            $table->string('seller_kota');
            $table->integer('harga');
            $table->integer('diskon')->default(0);
            $table->string('status');
            $table->string('gambar');
            $table->text('deskripsi_singkat');
            $table->text('deskripsi');
            $table->string('platform');
            $table->string('level');
            $table->text('item_unggulan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
