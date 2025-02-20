<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pengguna') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Notifikasi Flash -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Header Card -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h3>
            </div>
            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Foto
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Telepon
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $index => $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('storage/'.Auth::user()->image) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $user->phone }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" id="role-{{ $user->id }}">
                                    <span class="role-text">{{ $user->role }}</span>
                                    @if($user->role !== 'admin')
                                        <select class="hidden role-select" data-user-id="{{ $user->id }}">
                                            <option value="pengguna" {{ $user->role === 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                                            <option value="laboran" {{ $user->role === 'laboran' ? 'selected' : '' }}>Laboran</option>
                                            <option value="teknisi" {{ $user->role === 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                                        </select>
                                    @endif                                         
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex space-x-2">
                                        @if($user->role !== 'admin')
                                            <button class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition edit-btn" data-user-id="{{ $user->id }}">Edit</button>
                                            <button class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition cancel-btn hidden" data-user-id="{{ $user->id }}">Batal</button>
                                            <button class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition save-btn hidden" data-user-id="{{ $user->id }}">Simpan</button>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }} ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition delete-btn" data-user-id="{{ $user->id }}">Hapus</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">Tidak dapat diedit atau dihapus</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('.edit-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            let userId = this.dataset.userId;
                
                            // Sembunyikan teks dan tampilkan dropdown
                            document.querySelector(`#role-${userId} .role-text`).classList.add('hidden');
                            document.querySelector(`#role-${userId} .role-select`).classList.remove('hidden');
                
                            // Sembunyikan tombol edit, tampilkan tombol simpan dan batal
                            this.classList.add('hidden');
                            document.querySelector(`.save-btn[data-user-id='${userId}']`).classList.remove('hidden');
                            document.querySelector(`.cancel-btn[data-user-id='${userId}']`).classList.remove('hidden');
                
                            // Sembunyikan tombol hapus (fix: perbaiki class "delete-btn")
                            document.querySelector(`.delete-btn[data-user-id='${userId}']`).classList.add('hidden');
                        });
                    });
                
                    document.querySelectorAll('.cancel-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            let userId = this.dataset.userId;
                
                            // Tampilkan kembali teks dan sembunyikan dropdown
                            document.querySelector(`#role-${userId} .role-text`).classList.remove('hidden');
                            document.querySelector(`#role-${userId} .role-select`).classList.add('hidden');
                
                            // Tampilkan kembali tombol edit dan hapus
                            document.querySelector(`.edit-btn[data-user-id='${userId}']`).classList.remove('hidden');
                            document.querySelector(`.delete-btn[data-user-id='${userId}']`).classList.remove('hidden'); 
                
                            // Sembunyikan tombol simpan dan batal
                            document.querySelector(`.save-btn[data-user-id='${userId}']`).classList.add('hidden');
                            this.classList.add('hidden');
                        });
                    });
                
                    document.querySelectorAll('.save-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            let userId = this.dataset.userId;
                            let newRole = document.querySelector(`#role-${userId} .role-select`).value;
                            
                            fetch(`/users/${userId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ role: newRole })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data); // Debugging
                
                                if (data.success) {
                                    document.querySelector(`#role-${userId} .role-text`).textContent = newRole;
                                    document.querySelector(`#role-${userId} .role-text`).classList.remove('hidden');
                                    document.querySelector(`#role-${userId} .role-select`).classList.add('hidden');
                
                                    // Tampilkan kembali tombol edit dan hapus
                                    document.querySelector(`.edit-btn[data-user-id='${userId}']`).classList.remove('hidden');
                                    document.querySelector(`.delete-btn[data-user-id='${userId}']`).classList.remove('hidden');
                
                                    // Sembunyikan tombol simpan dan batal
                                    document.querySelector(`.save-btn[data-user-id='${userId}']`).classList.add('hidden');
                                    document.querySelector(`.cancel-btn[data-user-id='${userId}']`).classList.add('hidden');
                                }
                            });
                        });
                    });
                });
                </script>
                


            <!-- Footer Card (opsional: untuk pagination) -->
            <div class="px-6 py-4 bg-gray-50">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
