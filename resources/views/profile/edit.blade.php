<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-bold text-gray-900">{{ __('Account Management') }}</h2>
    </div>
  </x-slot>

  <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="{ activeModal: null }">
    <!-- Profile Card -->
    <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-6 mb-8 shadow-2xl">
      <div class="flex flex-col items-center text-center">
        <div class="relative mb-4">
          <img src="{{ asset('storage/'.Auth::user()->image) }}" 
               class="w-32 h-32 rounded-full border-4 border-white shadow-xl">
          <div class="absolute bottom-0 right-0 bg-white p-1.5 rounded-full shadow-md">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
            </svg>
          </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ Auth::user()->name }}</h1>
        <p class="text-gray-600 mb-4">{{ Auth::user()->email }}</p>
        <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
          {{ ucfirst(Auth::user()->role) }}
        </span>
      </div>
    </div>

    <!-- Action Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Profile Info Card -->
      <div @click="activeModal = 'profile'" 
           class="cursor-pointer transform transition-all hover:scale-105">
        <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl border border-gray-100">
          <div class="w-12 h-12 bg-blue-100 rounded-xl mb-4 flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Profile Info</h3>
          <p class="text-gray-500 text-sm">Update your personal information</p>
        </div>
      </div>

      <!-- Security Card -->
      <div @click="activeModal = 'security'" 
           class="cursor-pointer transform transition-all hover:scale-105">
        <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl border border-gray-100">
          <div class="w-12 h-12 bg-green-100 rounded-xl mb-4 flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Security</h3>
          <p class="text-gray-500 text-sm">Change password & security settings</p>
        </div>
      </div>

      <!-- Delete Account Card -->
      <div @click="activeModal = 'delete'" 
           class="cursor-pointer transform transition-all hover:scale-105">
        <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl border border-gray-100">
          <div class="w-12 h-12 bg-red-100 rounded-xl mb-4 flex items-center justify-center">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Account</h3>
          <p class="text-gray-500 text-sm">Permanently delete your account</p>
        </div>
      </div>
    </div>

   <!-- Profile Modal -->
<div x-show="activeModal === 'profile'" x-cloak 
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100">
  <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl overflow-y-auto max-h-[90vh]"
       @click.outside="activeModal = null">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h3 class="text-2xl font-bold text-gray-900">Edit Profile</h3>
      <button @click="activeModal = null" class="text-gray-400 hover:text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Form Container -->
    <div class="space-y-6">
      @include('profile.partials.update-profile-information-form')
      
      <!-- Fixed Footer -->
      <div>
        <div class="flex justify-end space-x-3">
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- Security Modal -->
    <div x-show="activeModal === 'security'" x-cloak 
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
      <div class="bg-white rounded-2xl w-full max-w-2xl p-6 shadow-2xl"
           @click.outside="activeModal = null">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-2xl font-bold text-gray-900">Security Settings</h3>
          <button @click="activeModal = null" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
        @include('profile.partials.update-password-form')
      </div>
    </div>

    <!-- Delete Account Modal -->
    <div x-show="activeModal === 'delete'" x-cloak 
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
      <div class="bg-white rounded-2xl w-full max-w-2xl p-6 shadow-2xl"
           @click.outside="activeModal = null">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-2xl font-bold text-red-600">Delete Account</h3>
          <button @click="activeModal = null" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
        <div class="bg-red-50 rounded-xl p-4 mb-6">
          <div class="flex items-center">
            <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
              <p class="text-red-800 font-medium">This action is permanent!</p>
              <p class="text-red-700 text-sm">All your data will be erased completely</p>
            </div>
          </div>
        </div>
        @include('profile.partials.delete-user-form')
      </div>
    </div>
  </div>
</x-app-layout>