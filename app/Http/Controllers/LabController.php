<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Labs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabController extends Controller
{

    public function getFakultas()
    {
        return response()->json(Fakultas::all());
    }

    public function getLabsByFakultas($fakultas_id)
    {
        $labs = Labs::where('fakultas_id', $fakultas_id)->get();
        return response()->json($labs);
    }

    public function index()
    {
        $labs = Labs::with('fakultas', 'user')->get();
        $fakultas = Fakultas::all();
        return view('features.labs', compact('labs', 'fakultas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama_lab' => 'required|string|max:255',
            'jumlah_meja' => 'required|integer|min:1',
        ]);

        try {
            $lab = new Labs();
            $lab->fakultas_id = $request->fakultas_id;
            $lab->nama_lab = $request->nama_lab;
            $lab->jumlah_meja = $request->jumlah_meja;
            $lab->user_id = Auth::id();
            $lab->save();

            return response()->json(['success' => true, 'message' => 'Lab berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }


        public function destroy(Labs $lab)
        {
            $lab->delete();
            return redirect()->back()->with('success', 'Data lab berhasil dihapus');
        }
    }
