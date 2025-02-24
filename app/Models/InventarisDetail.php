<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class InventarisDetail extends Model
{
    use HasFactory;
    protected $fillable = ['inventaris_id', 'kode_barang', 'nama_barang', 'merk/type', 'tahun_pembelian', 'jumlah', 'kondisi', 'keterangan'];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
