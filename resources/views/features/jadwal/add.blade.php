<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Jadwal') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800">Daftar Jadwal</h1>
                        <button onclick="tambahBaris()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-5 rounded-lg flex items-center transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Jadwal
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
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">File Jadwal</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Ditambahkan Oleh</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="jadwal-table-body" class="divide-y divide-gray-200">
                                @forelse($jadwal as $index => $jdwl)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-6">{{ $index + 1 }}</td>
                                        <td class="py-4 px-6">{{ $jdwl->fakultas->nama_fakultas }}</td>
                                        <td class="py-4 px-6">{{ $jdwl->lab->nama_lab }}</td>
                                        <td class="py-4 px-6">
                                            <a href="{{ asset('storage/' . $jdwl->jadwal) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                                Lihat Jadwal
                                            </a>
                                        </td>
                                        <td class="py-4 px-6">{{ $jdwl->user->name }}</td>
                                        <td class="py-4 px-6">
                                            <form action="{{ route('jadwal.destroy', $jdwl->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus jadwal ini?')"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition duration-150 ease-in-out">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-6 text-center text-gray-500">
                                            Tidak ada data jadwal
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
            let tableBody = document.getElementById('jadwal-table-body');
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
                    <input type="file" name="jadwal" accept="image/*" onchange="previewImage(this)"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <img id="preview" src="" alt="Preview" class="hidden w-24 h-auto mt-2 rounded-lg">
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

            let fakultasSelect = row.querySelector(".fakultas-select");
            let labSelect = row.querySelector(".lab-select");

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
            let fileInput = row.querySelector('input[name="jadwal"]');

            let formData = new FormData();
            formData.append("fakultas_id", fakultasId);
            formData.append("lab_id", labId);
            formData.append("jadwal", fileInput.files[0]);

            fetch("{{ route('jadwal.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: formData
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

        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = input.nextElementSibling; // Ambil elemen img setelah input
                    preview.src = e.target.result;
                    preview.classList.remove("hidden");
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>