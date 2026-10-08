<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_produk', 'nama_produk', 'kategori_id',
        'harga', 'stok', 'gambar', 'deskripsi',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}