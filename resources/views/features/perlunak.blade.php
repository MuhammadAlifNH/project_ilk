<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Daftar Perangkat Lunak</h1>
                        <button onclick="tambahBaris()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Perangkat
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg flex justify-between items-center">
                            <div>
                                <span class="font-medium">Sukses!</span> {{ session('success') }}
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fakultas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lab</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Perangkat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Versi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ditambahkan Oleh</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="perls-table-body" class="bg-white divide-y divide-gray-200">
                                @forelse($perlunak as $index => $perlk)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $perlk->fakultas->nama_fakultas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $perlk->lab->nama_lab }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $perlk->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $perlk->versi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $perlk->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <form action="{{ route('perlunak.destroy', $perlk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus {{ $perlk->nama }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium flex items-center">
                                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data perangkat lunak</td>
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
            row.className = 'bg-blue-50';
            row.innerHTML = `
                <td class="px-6 py-4 text-sm text-gray-500">#</td>
                <td class="px-6 py-4">
                    <select name="fakultas_id" class="fakultas-select w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Fakultas --</option>
                    </select>
                </td>
                <td class="px-6 py-4">
                    <select name="lab_id" class="lab-select w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                        <option value="">-- Pilih Lab --</option>
                    </select>
                </td>
                <td class="px-6 py-4">
                    <input type="text" name="nama" placeholder="Perangkat" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </td>
                <td class="px-6 py-4">
                    <input type="text" name="versi" placeholder="Versi" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ auth()->user()->name }}</td>
                <td class="px-6 py-4 space-x-2">
                    <button onclick="batalBaris(this)" class="px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-100 rounded-md transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </button>
                    <button onclick="simpanBaris(this)" class="px-3 py-1.5 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan
                    </button>
                </td>
            `;

            tableBody.insertBefore(row, tableBody.firstChild);

            // Load Fakultas
            const fakultasSelect = row.querySelector('.fakultas-select');
            fetch("/get-fakultas")
                .then(response => response.json())
                .then(data => {
                    data.forEach(fakultas => {
                        const option = document.createElement('option');
                        option.value = fakultas.id;
                        option.textContent = fakultas.nama_fakultas;
                        fakultasSelect.appendChild(option);
                    });
                });

            // Event listener untuk Fakultas
            fakultasSelect.addEventListener('change', function() {
                const labSelect = row.querySelector('.lab-select');
                labSelect.innerHTML = '<option value="">-- Pilih Lab --</option>';
                labSelect.disabled = true;

                if(this.value) {
                    fetch(`/get-labs/${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            if(data.length > 0) {
                                data.forEach(lab => {
                                    const option = document.createElement('option');
                                    option.value = lab.id;
                                    option.textContent = lab.nama_lab;
                                    labSelect.appendChild(option);
                                });
                                labSelect.disabled = false;
                            }
                        });
                }
            });
        }

        function simpanBaris(button) {
            let row = button.closest('tr');
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
                    versi: versi
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert("Gagal menyimpan: " + data.message);
                    row.classList.add('bg-red-50');
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat menyimpan data.");
                row.classList.add('bg-red-50');
            });
        }

        function batalBaris(button) {
            button.closest('tr').remove();
        }
    </script>
</x-app-layout>