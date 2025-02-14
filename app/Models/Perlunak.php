<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perlunak extends Model
{
    use HasFactory;

    protected $fillable = ['fakultas_id', 'lab_id', 'nama', 'versi', 'user_id'];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function lab()
    {
        return $this->belongsTo(Labs::class, 'lab_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }   
}
