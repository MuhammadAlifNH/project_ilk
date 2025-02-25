<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Inventaris') }}
            </h2>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Tambah Data Inventaris</h1>
                        <a href="{{ route('inventaris.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>

                    <form action="{{ route('inventaris.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Input Tanggal -->
                        <div class="mb-4">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                        </div>

                        <!-- Input Fakultas -->
                        <div class="mb-4">
                            <label for="fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                            <select name="fakultas_id" id="fakultas" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                <option value="">Pilih Fakultas</option>
                                @foreach($fakultas as $fakults)
                                    <option value="{{ $fakults->id }}">{{ $fakults->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Lab -->
                        <div class="mb-4">
                            <label for="labs" class="block text-sm font-medium text-gray-700">Lab</label>
                            <select name="lab_id" id="lab" required disabled
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                                <option value="">Pilih Lab</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Ditambahkan Oleh</label>
                            <input type="text" name="name" id="name" value="{{ Auth::user()->name ?? '' }}" readonly
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm">
                        </div>

                        <!-- Input Barang -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Data Barang</label>
                            <table class="w-full border border-gray-300 mt-2">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border px-2 py-1">Kode Barang</th>
                                        <th class="border px-2 py-1">Nama Barang</th>
                                        <th class="border px-2 py-1">Merk/Type</th>
                                        <th class="border px-2 py-1">Tahun</th>
                                        <th class="border px-2 py-1">Jumlah</th>
                                        <th class="border px-2 py-1">Kondisi</th>
                                        <th class="border px-2 py-1">Keterangan</th>
                                        <th class="border px-2 py-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="barang-table">
                                </tbody>
                            </table>
                            <button type="button" onclick="addBarang()"
                                class="mt-2 bg-green-600 hover:bg-green-700 text-white font-medium py-1 px-3 rounded-lg">
                                Tambah Barang
                            </button>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="mt-6">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fakultasSelect = document.getElementById("fakultas");
            const labSelect = document.getElementById("lab");

            fakultasSelect.addEventListener("change", function () {
                const fakultasId = this.value;
                labSelect.innerHTML = '<option value="">Pilih Lab</option>';
                labSelect.disabled = true;

                if (fakultasId) {
                    fetch(`/get-labs/${fakultasId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(lab => {
                                    const option = document.createElement("option");
                                    option.value = lab.id;
                                    option.textContent = lab.nama_lab;
                                    labSelect.appendChild(option);
                                });
                                labSelect.disabled = false;
                            }
                        })
                        .catch(error => console.error("Error fetching labs:", error));
                }
            });
        });

        function addBarang() {
            const table = document.getElementById('barang-table');
            const rowCount = table.rows.length; // Hitung jumlah baris yang ada
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-2 py-1"><input type="text" name="details[${rowCount}][kode_barang]" class="w-full"></td>
                <td class="border px-2 py-1"><input type="text" name="details[${rowCount}][nama_barang]" class="w-full" required></td>
                <td class="border px-2 py-1"><input type="text" name="details[${rowCount}][merk_type]" class="w-full"></td>
                <td class="border px-2 py-1"><input type="number" name="details[${rowCount}][tahun_pembelian]" class="w-full" required></td>
                <td class="border px-2 py-1"><input type="number" name="details[${rowCount}][jumlah]" class="w-full" required></td>
                <td class="border px-2 py-1">
                    <select name="details[${rowCount}][kondisi]" required>
                        <option value="Baik">Baik</option>
                        <option value="Buruk">Buruk</option>
                    </select>
                </td>
                <td class="border px-2 py-1"><input type="text" name="details[${rowCount}][keterangan]" class="w-full" required></td>
                <td class="border px-2 py-1"><button type="button" onclick="this.parentElement.parentElement.remove()">🗑️</button></td>
            `;
            table.appendChild(row);
        }
    </script>
</x-app-layout>
