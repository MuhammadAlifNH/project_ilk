@props(['user', 'roles' => ['admin', 'laboran', 'teknisi', 'pengguna']])

<div>
    <x-input-label for="role" class="block text-sm font-medium text-gray-700" :value="__('Role')" />
    <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        @foreach($roles as $role)
            <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('role')" />
</div>

@php
    // Jika user tidak mengganti role, maka verifikasi tidak diperlukan
    $requireVerification = old('role', $user->role) !== $user->role && old('role', $user->role) !== 'pengguna';
@endphp

<div id="verification-code-section" class="{{ $requireVerification ? '' : 'hidden' }}">
    <x-input-label for="verification_code" :value="__('Verification Code')" />
    <x-text-input id="verification_code" name="verification_code" type="password" class="mt-1 block w-full" autocomplete="off" />
    <x-input-error class="mt-2" :messages="$errors->get('verification_code')" />
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let roleInput = document.getElementById('role');
        let verificationCodeSection = document.getElementById('verification-code-section');
        let userCurrentRole = "{{ $user->role }}"; // Role yang tersimpan di database

        function checkRole() {
            let selectedRole = roleInput.value.toLowerCase();

            // Hanya tampilkan kode verifikasi jika role yang dipilih berbeda dari yang tersimpan dan bukan 'pengguna'
            if (selectedRole !== userCurrentRole && selectedRole !== 'pengguna') {
                verificationCodeSection.classList.remove('hidden');
            } else {
                verificationCodeSection.classList.add('hidden');
            }
        }

        roleInput.addEventListener('change', checkRole);
        checkRole();
    });
</script>
