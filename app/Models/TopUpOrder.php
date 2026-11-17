<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Satu TopUpOrder = satu pesanan top up game. Nominal disimpan
// sebagai angka rupiah; statusnya demo ("Menunggu").
class TopUpOrder extends Model
{
    protected $fillable = [
        'user_id', 'game', 'paket', 'nominal', 'game_user_id', 'status',
    ];

    protected $casts = [
        'nominal' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNominalLabel(): string
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }
}
