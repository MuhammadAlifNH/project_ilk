<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Kelola Fakultas') }}
    </h2>
  </x-slot>

  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Daftar Fakultas</h1>
                        <button onclick="tambahBaris()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Fakultas
                        </button>
                    </div>

      <!-- Flash Message -->
      @if(session('success'))
        <div class="px-6 py-3 bg-green-100 border border-green-400 text-green-700 rounded relative">
          {{ session('success') }}
          <button class="absolute top-0 right-0 px-3 py-1" onclick="this.parentElement.remove()">
            <svg class="w-5 h-5 fill-current text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <title>Close</title>
              <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
          </button>
        </div>
      @endif

      <!-- Card Container -->
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-gray-200">
        </div>
        <!-- Tabel Data -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Fakultas</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diinput oleh</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody id="fakultas-table-body" class="bg-white divide-y divide-gray-200">
              @forelse($fakultas as $index => $item)
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->nama_fakultas }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $item->user ? $item->user->name : 'User tidak ada' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex space-x-2">
                      <form action="{{ route('fakultas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Fakultas {{ $item->nama_fakultas }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                          Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data fakultas.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <!-- Card Footer: Pagination (jika menggunakan paginate) -->
        <div class="px-6 py-4 bg-gray-50">
          {{ $fakultas->links() }}
        </div>
      </div>
  <!-- JavaScript untuk tambah, simpan, dan batal baris -->
  <script>
    function tambahBaris() {
      let tableBody = document.getElementById('fakultas-table-body');
      let row = document.createElement('tr');
      row.className = 'hover:bg-gray-50 transition-colors new-row';
      row.innerHTML = `
        <td class="px-6 py-4 text-sm text-gray-500">#</td>
        <td class="px-6 py-4">
          <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="nama_fakultas" required>
        </td>
        <td class="px-6 py-4 text-sm text-gray-500">{{ auth()->user()->name }}</td>
        <td class="px-6 py-4 space-x-2">
          <button onclick="batalBaris(event, this)" class="px-3 py-1 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors">Batal</button>
          <button onclick="simpanBaris(event, this)" class="px-3 py-1 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors">Simpan</button>
        </td>
      `;
      tableBody.prepend(row);
    }

    function batalBaris(e, button) {
      e.preventDefault();
      let row = button.closest('tr');
      row.remove();
    }

    function simpanBaris(e, button) {
      e.preventDefault();
      let row = button.closest('tr');
      let namaFakultas = row.querySelector('input[name="nama_fakultas"]').value.trim();

      if (namaFakultas === "") {
        alert("Nama Fakultas tidak boleh kosong!");
        return;
      }

      fetch("{{ route('fakultas.store') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ nama_fakultas: namaFakultas })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error("Gagal menyimpan data");
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          alert(data.message);
          window.location.reload();
        } else {
          alert("Gagal menyimpan: " + data.message);
        }
      })
      .catch(error => {
        console.error("Error:", error);
        alert("Terjadi kesalahan saat menyimpan data.");
      });
    }
  </script>
</x-app-layout>
