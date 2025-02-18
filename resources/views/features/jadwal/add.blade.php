<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Jadwal') }}
        </h2>
    </x-slot>

    <body>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h1 class="text-3xl font-bold">Daftar Jadwal</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border">No</th>
                        <th class="py-2 px-4 border">Fakultas</th>
                        <th class="py-2 px-4 border">Lab</th>
                        <th class="py-2 px-4 border">File Jadwal</th>
                        <th class="py-2 px-4 border">Ditambahkan Oleh</th>
                        <th class="py-2 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="jadwal-table-body">
                    @forelse($jadwal as $index => $jdwl)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $jdwl->fakultas->nama_fakultas }}</td>
                            <td>{{ $jdwl->lab->nama_lab }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $jdwl->jadwal) }}" target="_blank" class="text-blue-600 underline">
                                    Lihat Jadwal
                                </a>
                            </td>
                            <td>{{ $jdwl->user->name }}</td>
                            <td>
                                <form action="{{ route('jadwal.destroy', $jdwl->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: rgb(255, 41, 41); padding: 5px;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data jadwal</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Tombol Tambah Data -->
            <div class="fixed bottom-4 right-4">
                <button onclick="tambahBaris()" style="background: rgb(125, 240, 125); padding: 10px;">Tambah Jadwal</button>
            </div>
        </div>

        <script>
            function tambahBaris() {
                let tableBody = document.getElementById('jadwal-table-body');
                let row = document.createElement('tr');

                row.innerHTML = `
                    <td>#</td>
                    <td>
                        <select name="fakultas_id" class="fakultas-select">
                            <option value="">-- Pilih Fakultas --</option>
                        </select>
                    </td>
                    <td>
                        <select name="lab_id" class="lab-select" disabled>
                            <option value="">-- Pilih Lab --</option>
                        </select>
                    </td>
                    <td>
                        <input type="file" name="jadwal" accept="image/*" onchange="previewImage(this)">
                        <img id="preview" src="" alt="Preview" style="display:none; width:100px; height:auto; margin-top:10px;">
                    </td>
                    <td>{{ auth()->user()->name }}</td>
                    <td>
                        <button onclick="simpanBaris(this)" style="background: rgb(125, 240, 125); padding: 5px;">Simpan</button>
                        <button onclick="batalBaris(this)" style="background: rgb(255, 41, 41); padding: 5px;">Batal</button>
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
                        preview.style.display = "block";
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>

    </body>
</x-app-layout>
