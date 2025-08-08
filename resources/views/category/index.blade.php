<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-box mr-2"></i>{{ __('Kategori') }}
            </h2>
            <a href="{{route('addcategory')}}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Daftar Kategori</h1>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg m-3 w-full">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @if($category->isNotEmpty())
                    @foreach( $category as $cate)
                    <tr class="border-b hover:bg-gray-50 text-center">
                        <td class="px-6 py-4">{{$cate->id}}</td>
                        <td class="px-6 py-4">{{$cate->name}}</td>
                        <td class="px-6 py-4">{{$cate->description}}</td>
                        <td class="px-6 py-4 text-center ">
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="text-gray-600 hover:text-gray-900 text-center font-bold w-full">
                                    ⋮
                                </button>
                                <div x-show="open" @click.away="open = false"
                                     class="absolute right-0 mt-2 w-28 bg-white border rounded shadow-md z-10"
                                     x-transition>
                                    <a href=""
                                       class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700">Edit</a>
                                    <form action="" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm text-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else 
                    <p>tidak ada data</p>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
