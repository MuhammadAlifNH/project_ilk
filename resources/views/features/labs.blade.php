<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Lab') }}
        </h2>
    </x-slot>

<body>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <h1 class="text-3xl font-bold">Daftar Lab</h1>

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
                    <th class="py-2 px-4 border">Jumlah Meja</th>
                    <th class="py-2 px-4 border">Ditambahkan Oleh</th>
                    <th class="py-2 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody id="lab-table-body">
                @forelse($labs as $index => $lab)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $lab->fakultas->nama_fakultas }}</td>
                        <td>{{ $lab->nama_lab }}</td>
                        <td>{{ $lab->jumlah_meja }}</td>
                        <td>{{ $lab->user->name }}</td>
                        <td>
                            <form action="{{ route('labs.destroy', $lab->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lab '+'{{$lab->nama_lab}}'+' ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: rgb(255, 41, 41); padding: 5px;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data lab</td>
                    </tr>
                @endforelse
                    </tbody>
                </table>
                <div class="fixed bottom-4 right-4">
                    <button onclick="tambahBaris()" style="background: rgb(125, 240, 125); padding: 10px;">Tambah Lab</button>
                </div>
            </div>

            <script>
                function tambahBaris() {
                    let tableBody = document.getElementById('lab-table-body');
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td>#</td>
                        <td>
                            <select name="fakultas_id" class="form-control" required>
                                @foreach($fakultas as $fakuls)
                                    <option value="{{ $fakuls->id }}">{{ $fakuls->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" class="form-control" name="nama_lab" required></td>
                        <td><input type="number" class="form-control" name="jumlah_meja" required></td>
                        <td>{{ auth()->user()->name }}</td>
                        <td>
                            <button onclick="batalBaris(this)" style="background: rgb(255, 41, 41); padding: 5px;">Batal</button>
                            <button onclick="simpanBaris(this)" style="background: rgb(125, 240, 125); padding: 5px;">Simpan</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                }
        
                function simpanBaris(button) {
                    let row = button.parentElement.parentElement;
                    let fakultasId = row.querySelector('select[name="fakultas_id"]').value;
                    let namaLab = row.querySelector('input[name="nama_lab"]').value;
                    let jumlahMeja = row.querySelector('input[name="jumlah_meja"]').value;

                    fetch("{{ route('labs.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            fakultas_id: fakultasId,
                            nama_lab: namaLab,
                            jumlah_meja: jumlahMeja
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
