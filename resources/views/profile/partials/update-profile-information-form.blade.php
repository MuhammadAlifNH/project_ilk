<section class="bg-white shadow rounded-lg p-6">
    <header>
        <h2 class="text-2xl font-semibold text-gray-800">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-gray-600">
            {{ __("Update your account's profile information and email role.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        
        <!-- Foto Profil dengan preview dan tombol ubah/hapus -->
        <div class="relative">
            <div class="w-32 h-32 rounded-full overflow-hidden border border-gray-300">
                <img id="profilePhotoPreview"
                    src="{{ $user->image ? asset('storage/'.$user->image) : asset('images/default-profile.png') }}"
                    alt="Profile Photo"
                    class="w-full h-full object-cover">

            </div>
            <button type="button"
                    onclick="document.getElementById('profile_photo').click()"
                    class="absolute bottom-0 right-0 bg-gray-800 text-white rounded-full p-2 hover:bg-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M4 5a2 2 0 012-2h4a2 2 0 012 2v1h3.5A1.5 1.5 0 0118 7.5v7A1.5 1.5 0 0116.5 16H3.5A1.5 1.5 0 012 14.5v-7A1.5 1.5 0 013.5 6H7V5z" />
                </svg>
            </button>
            @if($user->image)
                <div class="mt-2 text-center">
                    <button type="button"
                            onclick="removeProfilePhoto()"
                            class="text-sm text-red-600 hover:underline focus:outline-none">
                        {{ __('Remove Photo') }}
                    </button>
                </div>
            @endif
        </div>
        
        <!-- Field Informasi Profil -->
        <div class="flex-1 grid grid-cols-1 gap-5">
            <div>
                <x-input-label for="name" class="block text-sm font-medium text-gray-700" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                              :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" class="block text-sm font-medium text-gray-700" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                              :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email role is unverified.') }}
                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email role.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <x-input-label for="phone" class="block text-sm font-medium text-gray-700" :value="__('Nomor Telpone')" />
                <x-text-input id="phone" name="phone" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                              :value="old('phone', $user->phone)" required autofocus autocomplete="phone" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-role-input :user="$user" />
            </div>

            <div class="mt-6 flex items-center">
                <x-primary-button class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none">
                    {{ __('Save') }}
                </x-primary-button>
                @if (session('status') === 'profile-updated')
                    <p class="ml-4 text-sm text-green-600"
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)">
                        {{ __('Saved.') }}
                    </p>
                @endif
            </div>
        </div>
        <!-- Input file tersembunyi -->
        <input type="file" name="image" id="profile_photo" accept="image/*" class="hidden">
    </form>
</section>

<script>
    const profilePhotoInput = document.getElementById('profile_photo');
    const profilePhotoPreview = document.getElementById('profilePhotoPreview');
    
    if (profilePhotoInput) {
        profilePhotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePhotoPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
    
    function removeProfilePhoto() {
        // Set preview to placeholder image
        profilePhotoPreview.src = "{{ asset('images/profile-placeholder.png') }}";
        // Check if hidden input for removal already exists
        let removeInput = document.getElementById('remove_image');
        if (!removeInput) {
            // Create hidden input to signal removal of photo
            removeInput = document.createElement('input');
            removeInput.type = 'hidden';
            removeInput.name = 'remove_image';
            removeInput.value = '1';
            removeInput.id = 'remove_image';
            // Append the input to the form
            profilePhotoInput.closest('form').appendChild(removeInput);
        }
    }
</script>
