<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['nama', 'username', 'password', 'role', 'status'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'kasir_id');
    }

    public function logs()
    {
        return $this->hasMany(LogAktivitas::class, 'user_id');
    }
}