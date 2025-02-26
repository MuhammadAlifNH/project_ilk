<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Data Inventaris</h1>
                        <a href="{{ route('inventaris.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                                <div class="text-center">
                                    <h2 class="text-2xl font-bold">INVENTARIS</h2>
                                    <p class="text-lg font-semibold">
                                        RUANG LABORATORIUM {{ optional($inventaris->lab)->nama_lab ?? 'Tidak Diketahui' }},
                                        {{ optional($inventaris->fakultas)->nama_fakultas ?? 'Tidak Diketahui' }}
                                    </p>
                                    <p class="text-gray-600">UNIVERSITAS ISLAM NAHDLATUL ULAMA JEPARA</p>
                                    <p class="text-gray-600">Tanggal: {{ $inventaris->tanggal }}</p>
                                </div>
                
                                <div class="my-4 flex justify-end space-x-2">
                                    <button onclick="window.print()" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg">
                                        Print
                                    </button>
                                    <a href="{{ route('inventaris.download', $inventaris) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg">
                                        Download PDF
                                    </a>


                                </div>
                
                                <div class="border border-gray-300 rounded-lg p-4">
                                    <table class="w-full border-collapse border border-gray-400">
                                                <th class="border border-gray-400 px-4 py-2">No</th>
                                                <th class="border border-gray-400 px-4 py-2">Kode Barang</th>
                                                <th class="border border-gray-400 px-4 py-2">Nama Barang</th>
                                                <th class="border border-gray-400 px-4 py-2">Merk/Type</th>
                                                <th class="border border-gray-400 px-4 py-2">Tahun Pembelian</th>
                                                <th class="border border-gray-400 px-4 py-2">Jumlah</th>
                                                <th class="border border-gray-400 px-4 py-2">Kondisi</th>
                                                <th class="border border-gray-400 px-4 py-2">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventaris->details as $index => $item)
                                            <tr>
                                                <td class="border border-gray-400 px-4 py-2">{{ $index + 1 }}</td>
                                                <td class="border border-gray-400 px-4 py-2">{{ $item->kode_barang }}</td>
                                                <td class="border border-gray-400 px-4 py-2">{{ $item->nama_barang }}</td>
                                                <td class="border border-gray-400 px-4 py-2">{{ $item->merk_type }}</td>
                                                <td class="border border-gray-400 px-4 py-2">{{ $item->tahun_pembelian }}</td>
                                                <td class="border border-gray-400 px-4 py-2">{{ $item->jumlah }}</td>
                                                <td class="border border-gray-400 px-4 py-2">{{ $item->kondisi }}</td>
                                                <td class="border border-gray-400 px-4 py-2">{{ $item->keterangan }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                
                                <div class="mt-6 text-center">
                                    <p class="font-semibold">Koordinator Laboratorium Komputer</p>
                                    <br><br><br>
                                    <p class="font-bold">Muhamad Husen, S.Kom</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
