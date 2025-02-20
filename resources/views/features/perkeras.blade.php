<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Perangkat Keras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800">Daftar Perangkat Keras</h1>
                        <button onclick="tambahBaris()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-5 rounded-lg flex items-center transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Perangkat
                        </button>
                    </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabel Perangkat Keras -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-6 text-left text-sm font-semibold uppercase">No</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Fakultas</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Lab</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Nama Perangkat</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Merek</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Tahun Pembelian</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Ditambahkan Oleh</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="perks-table-body" class="divide-y divide-gray-200">
                        @forelse($perkeras as $index => $perkera)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="py-4 px-6">{{ $index + 1 }}</td>
                                <td class="py-4 px-6">{{ $perkera->lab->fakultas->nama_fakultas }}</td>
                                <td class="py-4 px-6">{{ $perkera->lab->nama_lab }}</td>
                                <td class="py-4 px-6">{{ $perkera->nama }}</td>
                                <td class="py-4 px-6">{{ $perkera->merek }}</td>
                                <td class="py-4 px-6">{{ $perkera->tahun_pembelian }}</td>
                                <td class="py-4 px-6">{{ $perkera->user->name }}</td>
                                <td class="py-4 px-6">
                                    <form action="{{ route('perkeras.destroy', $perkera->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus perangkat keras ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm transition duration-300 ease-in-out transform hover:scale-105">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-4 px-6 text-center text-gray-500">Tidak ada data perangkat keras</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <script>
            function tambahBaris() {
                let tableBody = document.getElementById('perks-table-body');
                let row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 transition duration-150 ease-in-out';

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
                        <input type="text" name="nama" placeholder="Perangkat" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </td>
                    <td class="py-4 px-6">
                        <input type="text" name="merek" placeholder="Merek" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </td>
                    <td class="py-4 px-6">
                        <input type="text" name="tahun_pembelian" placeholder="Tahun Pembelian" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </td>
                    <td class="py-4 px-6">{{ auth()->user()->name }}</td>
                    <td class="py-4 px-6">
                        <button onclick="simpanBaris(this)" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-full text-sm transition duration-300 ease-in-out transform hover:scale-105">
                            Simpan
                        </button>
                        <button onclick="batalBaris(this)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm transition duration-300 ease-in-out transform hover:scale-105">
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
                let merek = row.querySelector('input[name="merek"]').value;
                let tahun_pembelian = row.querySelector('input[name="tahun_pembelian"]').value;

                fetch("{{ route('perkeras.store') }}", {
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
                        merek: merek,
                        tahun_pembelian: tahun_pembelian
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload(); // Reload halaman setelah sukses
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
                row.remove(); // Hapus baris jika tombol Batal diklik
            }
        </script>
    </body>
</x-app-layout>