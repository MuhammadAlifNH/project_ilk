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
            'name'               => ['required', 'string', 'max:255'],
            'email'              => ['required', 'string', 'email', 'max:255'],
            'phone'              => ['nullable', 'regex:/^[0-9]+$/', 'max:13'],
            'role'               => ['required', 'string', Rule::in(['admin', 'laboran', 'teknisi', 'pengguna'])],
            'verification_code'  => ['nullable', 'string'],
            'image'              => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
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

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $user->image = $imagePath;
        }

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
