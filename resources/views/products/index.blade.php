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
                                    <div class="flex space-x-2" x-data="{ op: false }">
    <!-- Tombol buka modal -->
    <button 
        @click="op = true"
        type="button"
        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center py-2 px-3 rounded text-sm font-medium transition-colors"
    >
        <i class="fas fa-edit mr-1"></i>Edit
    </button>

    <!-- Modal -->
    <div 
        x-show="op" 
        x-transition 
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <!-- Konten Modal -->
        <div 
            class="bg-white w-[90%] md:w-[72%] max-h-[90%] rounded-lg shadow-lg overflow-auto p-6 relative"
            @click.away="op = false"
        >
            <!-- Tombol Close -->
            <button 
                @click="op = false" 
                class="absolute top-3 right-3 text-gray-600 hover:text-black text-xl"
            >&times;</button>

            <!-- Judul Modal -->
            <h2 class="text-2xl font-semibold mb-4">Edit Data Produk</h2>

            <!-- Form -->
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-4 grid-cols-2">
                @csrf
                @method('PUT')

                <!-- Gambar Produk -->
                <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                            <div x-data="imageUploader()" class="space-y-4">
                                <!-- Image Preview -->
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center"
                                     :class="{ 'border-blue-500 bg-blue-50': dragging }"
                                     @dragover.prevent="dragging = true"
                                     @dragleave.prevent="dragging = false"
                                     @drop.prevent="handleDrop($event)">
                                    
                                    <template x-if="!preview">
                                        <div>
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-600 mb-2">Drag & drop gambar di sini</p>
                                            <p class="text-sm text-gray-500 mb-4">atau</p>
                                            <button type="button" 
                                                    @click="$refs.fileInput.click()"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                                Pilih File
                                            </button>
                                        </div>
                                    </template>

                                    <template x-if="preview">
                                        <div class="relative">
                                            <img :src="preview" alt="Preview" class="max-w-full h-48 mx-auto rounded-lg object-cover">
                                            <button type="button" 
                                                    @click="preview = null; $refs.fileInput.value = ''"
                                                    class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <input type="file" 
                                       x-ref="fileInput"
                                       name="gambar-edit" 
                                       accept="image/*"
                                       @change="updatePreview($event.target.files[0])"
                                       class="hidden">
                                
                                <p class="text-xs text-gray-500">
                                    Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                                </p>
                            </div>
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="title" value="{{ $product['nama']  }}" class="border border-gray-300 rounded w-full p-2">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="4" class="border border-gray-300 rounded w-full p-2">{{ $product['deskripsi'] }}</textarea>
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="number" name="price" value="{{ $product['harga'] ?? '' }}" class="border border-gray-300 rounded w-full p-2">
                </div>

                <!-- SKU -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku" value="{{ $product['sku'] ?? '' }}" class="border border-gray-300 rounded w-full p-2">
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok</label>
                    <input type="number" name="stock" value="{{ $product['stok'] ?? '' }}" class="border border-gray-300 rounded w-full p-2">
                </div>

                <!-- Tombol Submit -->
                <div class="text-right pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
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