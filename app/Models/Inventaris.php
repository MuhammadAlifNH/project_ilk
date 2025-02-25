<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal', 'fakultas_id', 'lab_id', 'user_id'];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function lab()
    {
        return $this->belongsTo(Labs::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InventarisDetail::class);
    }

    public function getLabs($fakultasId)
    {
        return response()->json(Labs::where('fakultas_id', $fakultasId)->get());
    }

}

