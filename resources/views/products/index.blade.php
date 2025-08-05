<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-box mr-2"></i>{{ __('Daftar Produk') }}
            </h2>
            <a href="{{ route('products.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Search and Filter Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Search Input -->
                    <div class="flex-1 max-w-md">
                        <form method="GET" action="{{ route('products.index') }}" class="flex">
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
                            <!-- Add category options here -->
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

        <!-- Products Grid -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if(isset($products) && count($products) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($products as $product)
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <!-- Product Image -->
                                <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                                    <img src="{{ $product['gambar'] ?? 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                                         alt="{{ $product['nama'] }}" 
                                         class="w-full h-48 object-cover">
                                </div>

                                <!-- Product Info -->
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold mb-2 line-clamp-2">{{ $product['nama'] }}</h3>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product['deskripsi'] ?? 'Tidak ada deskripsi' }}</p>
                                    
                                    <!-- Price and Stock -->
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-lg font-bold text-blue-600">
                                            Rp{{ number_format($product['harga'] ?? 0, 0, ',', '.') }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            Stok: {{ $product['stok'] ?? 0 }}
                                        </span>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('products.show', $product['id'] ?? 1) }}" 
                                           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center py-2 px-3 rounded text-sm font-medium transition-colors">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>
                                        <a href="{{ route('products.edit', $product['id'] ?? 1) }}" 
                                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded text-sm font-medium transition-colors">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination (if needed) -->
                    <div class="mt-6 flex justify-center">
                        {{-- {{ $products->links() }} --}}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto mb-4 text-gray-300">
                            <i class="fas fa-box text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk</h3>
                        <p class="text-gray-500 mb-4">Mulai dengan menambahkan produk pertama Anda.</p>
                        <a href="{{ route('products.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Tambah Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>