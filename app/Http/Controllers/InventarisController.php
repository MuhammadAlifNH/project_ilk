<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Inventaris;
use App\Models\InventarisDetail;
use App\Models\Labs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarisController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::all();
        $inventaris = Inventaris::with('lab.fakultas', 'user')->get();
        return view('features.inventaris.index', compact('inventaris', 'fakultas'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        $labs = Labs::all();
        return view('features.inventaris.create', compact('fakultas', 'labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'fakultas_id' => 'required|exists:fakultas,id',
            'lab_id' => 'required|exists:labs,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $inventaris = Inventaris::create([
            'tanggal' => $request->tanggal,
            'fakultas_id' => $request->fakultas_id,
            'lab_id' => $request->lab_id,
            'user_id' => $request->user_id,
        ]);

        foreach ($request->details as $detail) {
            InventarisDetail::create([
                'inventaris_id' => $inventaris->id,
                'kode_barang' => $detail['kode_barang'],
                'nama_barang' => $detail['nama_barang'],
                'merk/type' => $detail['merk/type'],
                'tahun_pembelian' => $detail['tahun_pembelian'],
                'jumlah' => $detail['jumlah'],
                'kondisi' => $detail['kondisi'],
                'keterangan' => $detail['keterangan'],
            ]);
        }

        return redirect()->route('inventaris.index')->with('success', 'Inventaris berhasil ditambahkan');
    }

    public function view(Inventaris $inventaris)
    {
        $inventaris= Inventaris::with('fakultas', 'labs', 'user', 'details')->findOrFail($inventaris->id);
        return view('features.inventaris.view', compact('inventaris'));
    }

    public function destroy(Inventaris $inventaris)
    {
        $inventaris->delete();
        return redirect()->route('inventaris.index')->with('success', 'Inventaris berhasil dihapus');
    }
}
