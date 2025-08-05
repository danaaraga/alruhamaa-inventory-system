<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-user mr-2"></i>{{ __('Detail User: ') . $user->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('users.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['title' => 'Manajemen User', 'url' => route('users.index')],
            ['title' => 'Detail: ' . $user->name]
        ]" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="mb-4">
                            @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-gray-200">
                            @else
                            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mx-auto border-4 border-gray-200">
                                <i class="fas fa-user text-gray-400 text-4xl"></i>
                            </div>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-600 mb-3">{{ $user->email }}</p>
                        
                        @php
                        $roleClasses = [
                            'admin' => 'bg-red-100 text-red-800',
                            'manager' => 'bg-yellow-100 text-yellow-800',
                        ];
                        $roleClass = $roleClasses[$user->role] ?? 'bg-green-100 text-green-800';
                        @endphp
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $roleClass }}">
                            @if($user->role === 'admin')
                                <i class="fas fa-crown mr-1"></i>
                            @elseif($user->role === 'manager')
                                <i class="fas fa-user-tie mr-1"></i>
                            @else
                                <i class="fas fa-user mr-1"></i>
                            @endif
                            {{ ucfirst($user->role) }}
                        </span>

                        @if($user->id === auth()->id())
                        <div class="mt-3">
                            <span class="text-xs text-green-600 font-semibold bg-green-100 px-2 py-1 rounded">
                                <i class="fas fa-info-circle mr-1"></i>Akun Anda
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Details -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Detail</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Role</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ ucfirst($user->role) }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tanggal Bergabung</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d F Y, H:i') }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Terakhir Diupdate</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Status</label>
                                    <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h4>
                        
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('users.edit', $user) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                                <i class="fas fa-edit mr-2"></i>Edit User
                            </a>
                            
                            @if($user->id !== auth()->id())
                            <form method="POST" 
                                  action="{{ route('users.destroy', $user) }}" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}? Tindakan ini tidak dapat dibatalkan!')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                                    <i class="fas fa-trash mr-2"></i>Hapus User
                                </button>
                            </form>
                            @else
                            <span class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg flex items-center cursor-not-allowed">
                                <i class="fas fa-lock mr-2"></i>Tidak dapat menghapus akun sendiri
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Activity Log Card (Optional) -->
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Log Aktivitas Terbaru</h4>
                        
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-sign-in-alt text-green-500 mr-3"></i>
                                <span>Login terakhir: {{ $user->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-user-edit text-blue-500 mr-3"></i>
                                <span>Profil diupdate: {{ $user->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-user-plus text-green-500 mr-3"></i>
                                <span>Akun dibuat: {{ $user->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>