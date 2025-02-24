<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
    <!-- Kelola Pengguna -->
    <a href="{{ route('users.index') }}"
       class="flex flex-col items-center justify-center p-6 bg-gradient-to-r from-teal-400 to-blue-500 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-3a4 4 0 11-8 0 4 4 0 018 0z" />
      </svg>
      <h3 class="mt-4 text-xl font-semibold text-white">Kelola Pengguna</h3>
    </a>

    <!-- Kelola Fakultas -->
    <a href="{{ route('fakultas.index') }}"
       class="flex flex-col items-center justify-center p-6 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M12 14l9-5-9-5-9 5 9 5z" />
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M12 14l6.16-3.422a12.083 12.083 0 01.84 6.062L12 21" />
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M12 14l-6.16-3.422a12.083 12.083 0 00-.84 6.062L12 21" />
      </svg>
      <h3 class="mt-4 text-xl font-semibold text-white">Kelola Fakultas</h3>
    </a>

    <!-- Kelola Lab -->
    <a href="{{ route('labs.index') }}"
       class="flex flex-col items-center justify-center p-6 bg-gradient-to-r from-green-400 to-blue-400 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M21 16V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8M7 12h10" />
      </svg>
      <h3 class="mt-4 text-xl font-semibold text-white">Kelola Lab</h3>
    </a>

    <!-- Kelola Perangkat Keras -->
    <a href="{{ route('perkeras.index') }}"
       class="flex flex-col items-center justify-center p-6 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M9.75 17L9 21h6l-.75-4M4 6h16M4 6a2 2 0 012-2h12a2 2 0 012 2M4 6v10a2 2 0 002 2h12a2 2 0 002-2V6" />
      </svg>
      <h3 class="mt-4 text-xl font-semibold text-white">Kelola Perangkat Keras</h3>
    </a>

    <!-- Kelola Perangkat Lunak -->
    <a href="{{ route('perlunak.index') }}"
       class="flex flex-col items-center justify-center p-6 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M16 18l6-6-6-6M8 6l-6 6 6 6" />
      </svg>
      <h3 class="mt-4 text-xl font-semibold text-white">Kelola Perangkat Lunak</h3>
    </a>

    <a href="{{ route('jadwal.index') }}"
       class="flex flex-col items-center justify-center p-6 bg-gradient-to-r from-blue-400 to-yellow-400 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
               d="M21 16V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8M7 12h10" />
      </svg>
      <h3 class="mt-4 text-xl font-semibold text-white">Kelola Jadwal</h3>
    </a>

      <a href="{{ route('inventaris.index') }}"
         class="flex flex-col items-center justify-center p-6 bg-gradient-to-r from-red-400 to-pink-400 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
         <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
         </svg>
         <h3 class="mt-4 text-xl font-semibold text-white">Kelola Inventaris</h3>
      </a>
      
  </div>
</div>
