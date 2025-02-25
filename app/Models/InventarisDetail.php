<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class InventarisDetail extends Model
{
    use HasFactory;
    protected $fillable = ['inventaris_id', 'kode_barang', 'nama_barang', 'merk_type', 'tahun_pembelian', 'jumlah', 'kondisi', 'keterangan'];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

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

    public function getLabs($fakultasId)
    {
        return response()->json(Labs::where('fakultas_id', $fakultasId)->get());
    }

}
