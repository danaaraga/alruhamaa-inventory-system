<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-plus mr-2"></i>{{ __('Tambah Produk Baru') }}
            </h2>
            <a href="{{ route('products.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column - Product Info -->
                    <div class="space-y-4">
                        <!-- Product Name -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text"
                                id="nama"
                                name="nama"
                                value="{{ old('nama') }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan nama produk">
                            @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div x-data="{ harga: '' }">
                            <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="text"
                                    id="harga"
                                    name="harga"
                                    x-model="harga"
                                    x-on:input="harga = new Intl.NumberFormat('id-ID').format(harga.replace(/[^0-9]/g, ''))"
                                    required
                                    class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-lg 
                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="0">
                            </div>
                            @error('harga')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div x-data="{ qty: {{ old('stok', 0) }} }" class="w-48">
                            <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">
                                Stok Barang <span class="text-red-500">*</span>
                            </label>

                            <div class="flex rounded-lg border border-gray-300 overflow-hidden w-full">
                                <!-- Tombol Minus -->
                                <button type="button"
                                    @click="if(qty > 0) qty--"
                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700">
                                    -
                                </button>

                                <!-- Input Angka -->
                                <input type="number"
                                    id="stok"
                                    name="stok"
                                    x-model="qty"
                                    min="0"
                                    class="w-full text-center focus:outline-none"
                                    placeholder="0">

                                <!-- Tombol Plus -->
                                <button type="button"
                                    @click="qty++"
                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700">
                                    +
                                </button>


                            </div>

                            @error('stok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">satuan<span class="text-red-500">*</span></label>
                                <input type="text"
                                    id="nama"
                                    name="satuan"
                                    value="{{ old('satuan') }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Masukkan satuan stok produk (kg/liter/..)">
                                @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                        </div>
                        <!-- Category -->
                        <div>
                            <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select id="kategori_id" required
                                name="kategori_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @foreach($category as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column - Image Upload -->
                    <div class="space-y-4">
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
                                    name="gambar"
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
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('products.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Produk
                    </button>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>