<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Perangkat Lunak') }}
            </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800">Daftar Perangkat Lunak</h1>
                        <button onclick="tambahBaris()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-5 rounded-lg flex items-center transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Perangkat
                        </button>
                    </div>


                    <!-- Notifikasi Sukses -->
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Tabel Responsive -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full rounded-lg">
                            <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                                <tr>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">No</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Fakultas</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Lab</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Nama Perangkat</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Versi</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Ditambahkan Oleh</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="perls-table-body" class="divide-y divide-gray-200">
                                @forelse($perlunak as $index => $perlk)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-6">{{ $index + 1 }}</td>
                                        <td class="py-4 px-6">{{ $perlk->fakultas->nama_fakultas }}</td>
                                        <td class="py-4 px-6">{{ $perlk->lab->nama_lab }}</td>
                                        <td class="py-4 px-6">{{ $perlk->nama }}</td>
                                        <td class="py-4 px-6">{{ $perlk->versi }}</td>
                                        <td class="py-4 px-6">{{ $perlk->user->name }}</td>
                                        <td class="py-4 px-6">
                                            <form action="{{ route('perlunak.destroy', $perlk->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus {{ $perlk->nama }}?')"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition duration-150 ease-in-out">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 px-6 text-center text-gray-500">
                                            Tidak ada data perangkat lunak
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function tambahBaris() {
            let tableBody = document.getElementById('perls-table-body');
            let row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition-colors';

            row.innerHTML = `
                <td class="py-4 px-6">#</td>
                <td class="py-4 px-6">
                    <select name="fakultas_id" class="fakultas-select w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Fakultas --</option>
                    </select>
                </td>
                <td class="py-4 px-6">
                    <select name="lab_id" class="lab-select w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                        <option value="">-- Pilih Lab --</option>
                    </select>
                </td>
                <td class="py-4 px-6">
                    <input type="text" name="nama" placeholder="Perangkat" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </td>
                <td class="py-4 px-6">
                    <input type="text" name="versi" placeholder="Versi" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </td>
                <td class="py-4 px-6">{{ auth()->user()->name }}</td>
                <td class="py-4 px-6 space-x-2">
                    <button onclick="simpanBaris(this)" 
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm transition duration-150 ease-in-out">
                        Simpan
                    </button>
                    <button onclick="batalBaris(this)" 
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition duration-150 ease-in-out">
                        Batal
                    </button>
                </td>
            `;

            tableBody.appendChild(row);

            // Ambil elemen select fakultas & lab dalam row yang baru
            let fakultasSelect = row.querySelector(".fakultas-select");
            let labSelect = row.querySelector(".lab-select");

            // Load fakultas dari database
            fetch("/get-fakultas")
                .then(response => response.json())
                .then(data => {
                    data.forEach(fakultas => {
                        let option = document.createElement("option");
                        option.value = fakultas.id;
                        option.textContent = fakultas.nama_fakultas;
                        fakultasSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error fetching fakultas:", error));

            // Event listener untuk fakultas -> load lab sesuai fakultas yang dipilih
            fakultasSelect.addEventListener("change", function () {
                const fakultasId = this.value;
                labSelect.innerHTML = '<option value="">-- Pilih Lab --</option>';
                labSelect.disabled = true;

                if (fakultasId) {
                    fetch(`/get-labs/${fakultasId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {  
                                data.forEach(lab => {
                                    let option = document.createElement("option");
                                    option.value = lab.id;
                                    option.textContent = `${lab.nama_lab}`;
                                    labSelect.appendChild(option);
                                });
                                labSelect.disabled = false;
                            }
                        })
                        .catch(error => console.error("Error fetching labs:", error));
                }
            });
        }

        function simpanBaris(button) {
            let row = button.parentElement.parentElement;
            let fakultasId = row.querySelector('select[name="fakultas_id"]').value;
            let labId = row.querySelector('select[name="lab_id"]').value;
            let nama = row.querySelector('input[name="nama"]').value;
            let versi = row.querySelector('input[name="versi"]').value;

            fetch("{{ route('perlunak.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    fakultas_id: fakultasId,
                    lab_id: labId,
                    nama: nama,
                    versi: versi,                            
                })
            })
            .then(response => response.json())
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

        function batalBaris(button) {
            let row = button.parentElement.parentElement;
            row.remove();
        }
    </script>
</x-app-layout>