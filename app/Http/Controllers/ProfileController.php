<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
        // Validasi input termasuk field phone dan file image
        $data = $request->validate([
            'image'              => ['nullable', 'image', 'max:2048'], // maksimal 2MB
            'name'               => ['required', 'string', 'max:255'],
            'email'              => ['required', 'string', 'email', 'max:255'],
            'phone'              => ['nullable', 'regex:/^[0-9]+$/', 'max:13'],
            'role'               => ['required', 'string', Rule::in(['admin', 'laboran', 'teknisi', 'pengguna'])],
            'verification_code'  => ['nullable', 'string'],
        ]);

        $user = $request->user();
        $roleBerubah = $user->role !== $request->role;

        // Cek verifikasi role jika role berubah (kecuali menjadi 'pengguna')
        if ($roleBerubah && $request->role !== 'pengguna') {
            $validCodes = [
                'admin'   => env('ADMIN_VERIFICATION_CODE', '123abc'),
                'laboran' => env('LABORAN_VERIFICATION_CODE', '456def'),
                'teknisi' => env('TEKNISI_VERIFICATION_CODE', '789ghi'),
            ];

            if (empty($request->verification_code)) {
                return back()->withErrors(['verification_code' => 'Kode verifikasi diperlukan untuk mengganti role.']);
            }

            if ($request->verification_code !== ($validCodes[$request->role] ?? null)) {
                return back()->withErrors(['verification_code' => 'Kode verifikasi salah.']);
            }
        }

        // Proses upload foto profil jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan file baru dan tetapkan path-nya
            $data['profile_photo_path'] = $request->file('image')->store('images', 'public');
        } else {
            // Jika tidak ada file baru, pertahankan nilai lama
            $data['profile_photo_path'] = $user->profile_photo_path;
        }

        // Hapus key 'image' karena tidak ingin menyimpan data mentah file
        unset($data['image']);

        $oldEmail = $user->email;
        // Jika email berubah, reset verifikasi email
        if ($oldEmail !== $data['email']) {
            $data['email_verified_at'] = null;
        }

        // Update data user sekaligus
        $user->update($data);

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
