<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Profile') }}</h2>
    </div>
  </x-slot>

  <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="{ tab: 'profile-info' }">
    <!-- Profile Header with Gradient Background -->
    <div class="bg-gradient-to-r from-indigo-700 via-indigo-500 to-blue-500 rounded-lg shadow-lg overflow-hidden">
      <div class="flex items-center p-6">
        <img src="{{ asset('storage/'.Auth::user()->image) }}" alt="Profile Photo" class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-md">
        <div class="ml-6">
          <h1 class="text-3xl font-bold text-white">{{ Auth::user()->name }}</h1>
          <p class="text-white opacity-75">{{ Auth::user()->email }}</p>
          <p class="text-sm text-white uppercase tracking-wide">{{ ucfirst(Auth::user()->role) }}</p>
        </div>
      </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="mt-8">
      <nav class="flex border-b border-gray-200">
        <a href="#" 
           @click.prevent="tab = 'profile-info'" 
           :class="tab === 'profile-info' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500 hover:text-gray-700'" 
           class="mr-8 pb-2 text-lg font-medium transition duration-300">
          Profile Information
        </a>
        <a href="#" 
           @click.prevent="tab = 'password'" 
           :class="tab === 'password' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500 hover:text-gray-700'" 
           class="mr-8 pb-2 text-lg font-medium transition duration-300">
          Update Password
        </a>
        <a href="#" 
           @click.prevent="tab = 'delete-account'" 
           :class="tab === 'delete-account' ? 'border-b-2 border-red-600 text-red-600' : 'text-gray-500 hover:text-gray-700'" 
           class="mr-8 pb-2 text-lg font-medium transition duration-300">
          Delete Account
        </a>
      </nav>
    </div>

    <!-- Tab Content -->
    <div class="mt-6 space-y-6">
      <div x-show="tab === 'profile-info'" x-cloak
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 transform translate-y-2"
           x-transition:enter-end="opacity-100 transform translate-y-0">
        @include('profile.partials.update-profile-information-form')
      </div>
      <div x-show="tab === 'password'" x-cloak
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 transform translate-y-2"
           x-transition:enter-end="opacity-100 transform translate-y-0">
        @include('profile.partials.update-password-form')
      </div>
      <div x-show="tab === 'delete-account'" x-cloak
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 transform translate-y-2"
           x-transition:enter-end="opacity-100 transform translate-y-0">
        @include('profile.partials.delete-user-form')
      </div>
    </div>
  </div>
</x-app-layout>
