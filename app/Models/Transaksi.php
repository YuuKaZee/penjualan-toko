<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi', 'type', 'kasir_id',
        'customer_name', 'customer_phone', 'customer_address', 'customer_note',
        'order_status',
        'total', 'bayar', 'kembalian', 'tanggal_transaksi',
    ];

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}