<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    // Tentukan field yang dapat diisi
    protected $fillable = [
        'nama_fakultas',
        'user_id',
    ];

    /**
     * Relasi: Fakultas dimiliki oleh User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Fakultas memiliki banyak Labs
     */
    public function labs()
    {
        return $this->hasMany(Labs::class);
    }

    /**
     * Relasi: Fakultas memiliki banyak Perkeras
     */
    public function perkeras()  
    {
        return $this->hasManyThrough(Perkeras::class, Labs::class);
    }

    /**
     * Relasi: Fakultas memiliki banyak Perlunak
     */
    public function perlunak()
    {
        return $this->hasManyThrough(Perlunak::class, Labs::class);
    }

    public function jadwal()
    {
        return $this->hasManyThrough(Jadwal::class, Labs::class);
    }
}

