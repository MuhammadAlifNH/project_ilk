<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Perangkat Lunak') }}
        </h2>
    </x-slot>

<body>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <h1 class="text-3xl font-bold">Daftar Perangkat Lunak</h1>

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
                    <th class="py-2 px-4 border">Nama Perangkat</th>
                    <th class="py-2 px-4 border">Versi</th>
                    <th class="py-2 px-4 border">Ditambahkan Oleh</th>
                    <th class="py-2 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody id="perls-table-body">
                @forelse($perlunak as $index => $perlk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $perlk->fakultas->nama_fakultas }}</td>
                        <td>{{ $perlk->lab->nama_lab }}</td>
                        <td>{{ $perlk->nama }}</td>
                        <td>{{ $perlk->versi }}</td>
                        <td>{{ $perlk->user->name }}</td>
                        <td>
                            <form action="{{ route('perlunak.destroy', $perlk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus perangkat lunak '+'{{$perlk->nama}}'+' ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: rgb(255, 41, 41); padding: 5px;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data perangkat lunak</td>
                    </tr>
                @endforelse
                    </tbody>
                </table>
                <div class="fixed bottom-4 right-4">
                    <button onclick="tambahBaris()" style="background: rgb(125, 240, 125); padding: 10px;">Tambah Data</button>
                </div>
            </div>

            <script>
                function tambahBaris() {
                    let tableBody = document.getElementById('perls-table-body');
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
                        <td><input type="text" name="nama" placeholder="Perangkat"></td>
                        <td><input type="text" name="versi" placeholder="Versi"></td>
                        <td>{{ auth()->user()->name }}</td>
                        <td>
                            <button onclick="simpanBaris(this)" style="background: rgb(125, 240, 125); padding: 5px;">Simpan</button>
                            <button onclick="batalBaris(this)" style="background: rgb(255, 41, 41); padding: 5px;">Batal</button>
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
