<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labs extends Model
{
    use HasFactory;

    protected $fillable = ['fakultas_id', 'nama_lab', 'user_id', 'jumlah_meja'];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perkeras()
    {
        return $this->hasMany(Perkeras::class, 'lab_id');
    }

    public function perlunak()
    {
        return $this->hasMany(Perlunak::class, 'lab_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'lab_id');
    }
}
