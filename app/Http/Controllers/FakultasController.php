<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FakultasController extends Controller
{
    public function index()
    {
        // Ambil data fakultas
        $fakultas = Fakultas::paginate(10); // misalnya 10 data per halaman

        return view('features.fakultas', compact('fakultas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
        ]);

        $fakultas = Fakultas::create([
            'nama_fakultas' => $request->nama_fakultas,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'id' => $fakultas->id,
            'nama_fakultas' => $fakultas->nama_fakultas,
            'user_name' => Auth::user()->name,
        ]);
    }


    public function destroy(Fakultas $fakultas)
    {
        // Hapus data
        $fakultas->delete();

        return redirect()->back()->with('success', 'Data fakultas berhasil dihapus');
    }

    public function edit(Fakultas $fakultas)
    {
    return view('features.fakultas_edit', compact('fakultas'));
    }

    
}
