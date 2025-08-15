<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-box mr-2"></i>{{ __('inventory') }}
            </h2>
            <a href="{{ route('products.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Produk
            </a>

        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Search Input -->
                <div class="flex-1 max-w-md">
                    <form method="GET" action="{{ route('invent') }}" class="flex">
                        <div class="relative flex-1">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari produk..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Filter Options -->
                <div class="flex items-center space-x-2">
                    <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Kategori</option>
                        <select name="" id=""></select>
                    </select>
                    <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="nama">Nama A-Z</option>
                        <option value="harga_asc">Harga Terendah</option>
                        <option value="harga_desc">Harga Tertinggi</option>
                        <option value="terbaru">Terbaru</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


    <div class="overflow-x-auto bg-white shadow rounded-lg m-3 w-full">
        <form action="{{route('updateAll')}}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full border-collapse border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Harga</th>
                        <th class="border px-4 py-2">SKU</th>
                        <th class="border px-4 py-2">Stok</th>
                        <th class="border px-4 py-2">satuan</th>
                        <th class="border px-4 py-2">Kategori</th>
                        <th class="border px-4 py-2">Deskripsi</th>
                        <th class="border px-4 py-2">aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                    <tr class="border-b hover:bg-gray-50 text-center">
                        <td class="border px-4 py-2">
                            {{ $p->id }}
                            <input type="hidden" name="produk[{{ $p->id }}][id]" value="{{ $p->id }}">
                        </td>
                        <td class="border px-4 py-2">
                            <input type="text" name="produk[{{ $p->id }}][name]" value="{{ $p->name }}" class="w-full border-none">
                        </td>
                        <td class="border px-4 py-2">
                            <input type="number" name="produk[{{ $p->id }}][price]" value="{{ $p->price }}" class="w-full border-none">
                        </td>
                        <td class="border px-4 py-2">
                            <input type="text" name="produk[{{ $p->id }}][sku]" value="{{ $p->sku }}" class="w-full border-none">
                        </td>
                        <td class="border px-4 py-1">
                            <input type="number" name="produk[{{ $p->id }}][stock_quantity]" value="{{ $p->stock_quantity }}" class="w-full border-none">
                        </td>
                        <td class="px-4 py-2">
                        <input type="text" name="produk[{{ $p->id }}][satuan]" value="{{ $p->satuan}}" class="w-full border-none">
                        </td>
                        <td class="border px-4 py-2">
                            <select name="produk[{{ $p->id }}][category_id]" class="w-full">
                                @foreach ($category as $c)
                                <option value="{{ $c->id }}" {{ $p->category_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="border px-4 py-2">
                            <input type="text" name="produk[{{ $p->id }}][description]" value="{{ $p->description }}" class="w-full border-none">
                        </td>
                        <td class="p-5">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex justify-center p-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </button>
            </div>
        </form>
    </div>




</x-app-layout>