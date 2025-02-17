<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Fakultas') }}
        </h2>
    </x-slot>
<body>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <h1 class="text-3xl font-bold">Daftar Fakultas</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border">No</th>
                    <th class="py-2 px-4 border">Nama Fakultas</th>
                    <th class="py-2 px-4 border">Diinput oleh</th>
                    <th class="py-2 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody id="fakultas-table-body">
                @forelse($fakultas as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_fakultas }}</td>
                        <td>{{ $item->user ? $item->user->name : 'User tidak ada' }}</td>
                        <td>
                            <form action="{{ route('fakultas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Fakultas ' + '{{ $item->nama_fakultas}}' + '?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: rgb(255, 41, 41); padding: 5px;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data fakultas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="fixed bottom-4 right-4">
            <button onclick="tambahBaris()" style="background: rgb(125, 240, 125); padding: 10px;">Tambah Fakultas</button>
        </div>
    </div>

    <script>
        function tambahBaris() {
            let tableBody = document.getElementById('fakultas-table-body');
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>#</td>
                <td><input type="text" class="form-control" name="nama_fakultas" required></td>
                <td>{{ auth()->user()->name }}</td>
                <td>
                    <button onclick="batalBaris(this)" style="background: rgb(255, 41, 41); padding: 5px;">Batal</button>
                    <button onclick="simpanBaris(this)" style="background: rgb(120, 200, 253); padding: 5px;">Simpan</button>
                </td>
            `;
            tableBody.appendChild(row);
        }

        function simpanBaris(button) {
            let row = button.parentElement.parentElement;
            let namaFakultas = row.querySelector('input[name="nama_fakultas"]').value;

            fetch("{{ route('fakultas.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
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
                console.log("Data berhasil disimpan:", data);
                window.location.reload(); // Muat ulang halaman
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
