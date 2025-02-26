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
            'details' => 'required|array',
            'details.*.kode_barang' => 'nullable|string',
            'details.*.nama_barang' => 'required|string',
            'details.*.merk_type' => 'nullable|string',
            'details.*.tahun_pembelian' => 'required|integer',
            'details.*.jumlah' => 'required|integer',
            'details.*.kondisi' => 'required|string',
            'details.*.keterangan' => 'required|string',
        ]);

        try {
            // Simpan data utama ke tabel inventaris
            $inventaris = Inventaris::create([
                'tanggal' => $request->tanggal,
                'fakultas_id' => $request->fakultas_id,
                'lab_id' => $request->lab_id,
                'user_id' => Auth::id(), // Simpan ID pengguna yang menambahkan
            ]);

            // Simpan setiap detail barang ke tabel inventaris_details
            foreach ($request->details as $detail) {
                InventarisDetail::create([
                    'inventaris_id' => $inventaris->id, // Hubungkan dengan inventaris_id
                    'kode_barang' => $detail['kode_barang'] ?? '-',
                    'nama_barang' => $detail['nama_barang'],
                    'merk_type' => $detail['merk_type'] ?? '-',
                    'tahun_pembelian' => $detail['tahun_pembelian'],
                    'jumlah' => $detail['jumlah'],
                    'kondisi' => $detail['kondisi'],
                    'keterangan' => $detail['keterangan'],
                ]);
            }

            return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    public function show( $id)
    {
        // Eager load relasi jika belum ter-load
        $inventaris = Inventaris::findOrFail($id)->load(['lab', 'fakultas', 'details']);
        return view('features.inventaris.show', compact('inventaris'));
    }
    
    

    public function destroy($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->delete();

        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil dihapus.');
    }

    public function download($id)
    {
        $inventaris = Inventaris::with(['lab', 'fakultas', 'details'])->findOrFail($id);
        $pdf = PDF::loadView('features.inventaris.pdf', compact('inventaris'));
        return $pdf->download('inventaris_' . $inventaris->id . '.pdf');
    }


}
