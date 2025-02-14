<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Tampilkan form profil pengguna.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Perbarui informasi profil pengguna.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validasi input termasuk field phone
        $data = $request->validate([
            'image' => ['nullable', 'image', 'max:2048'], // Maksimal 2MB
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'regex:/^[0-9]+$/', 'max:13'], // Validasi field phone
            'role' => ['required', 'string', Rule::in(['admin', 'laboran', 'teknisi', 'pengguna'])],
            'verification_code' => ['nullable', 'string'],
        ]);

        $user = $request->user();
        // Cek apakah role berubah dari sebelumnya
        $roleBerubah = $user->role !== $request->role;

        // Hanya cek kode verifikasi jika role berubah dan role yang baru bukan "pengguna"
        if ($roleBerubah && $request->role !== 'pengguna') {
            $adminCode   = env('ADMIN_VERIFICATION_CODE', '123abc');
            $laboranCode = env('LABORAN_VERIFICATION_CODE', '456def');
            $teknisiCode = env('TEKNISI_VERIFICATION_CODE', '789ghi');

            $validCodes = [
                'admin'   => $adminCode,
                'laboran' => $laboranCode,
                'teknisi' => $teknisiCode,
            ];

            // Pastikan kode verifikasi diisi jika role berubah
            if (empty($request->verification_code)) {
                return back()->withErrors(['verification_code' => 'Kode verifikasi diperlukan untuk mengganti role.']);
            }

            // Pastikan kode verifikasi cocok dengan yang ada di .env
            if ($request->verification_code !== ($validCodes[$request->role] ?? null)) {
                return back()->withErrors(['verification_code' => 'Kode verifikasi salah.']);
            }
        }
        
        $user = $request->user();
        $oldEmail = $user->email;

        $user->update([
            'image' => $request->file('image') ? $request->file('image')->store('images', 'public') : $user->image,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        // Jika email berubah, reset verifikasi email
        if ($oldEmail !== $data['email']) {
            $user->email_verified_at = null;
        }

        // Isi data pengguna dengan data yang telah divalidasi (termasuk phone)
        $user->fill($data);
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validasi password untuk penghapusan akun
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [], 'userDeletion');

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
