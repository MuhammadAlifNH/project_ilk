<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Fakultas;
use App\Models\Lab;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil 5 data terakhir sebagai contoh preview
        $latestUsers = User::latest()->take(5)->get();
        $latestFakultas = Fakultas::latest()->take(5)->get();
        $latestLabs = Lab::latest()->take(5)->get();
        
        // Jika ada "Kelola Perangkat Keras/Lunak", siapkan datanya juga

        return view('dashboard', [
            'latestUsers' => $latestUsers,
            'latestFakultas' => $latestFakultas,
            'latestLabs' => $latestLabs,
        ]);
    }
}
