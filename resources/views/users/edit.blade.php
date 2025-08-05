<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-user-edit mr-2"></i>{{ __('Edit User: ') . $user->name }}
            </h2>
            <a href="{{ route('users.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['title' => 'Manajemen User', 'url' => route('users.index')],
            ['title' => 'Edit: ' . $user->name]
        ]" />

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column - User Info -->
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select id="role" 
                                        name="role" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                    Password Baru (Kosongkan jika tidak ingin mengubah)
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           placeholder="Masukkan password baru">
                                    <button type="button" 
                                            onclick="togglePassword('password')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i id="password-icon" class="fas fa-eye-slash text-gray-400"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                    Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           placeholder="Konfirmasi password baru">
                                    <button type="button" 
                                            onclick="togglePassword('password_confirmation')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i id="password_confirmation-icon" class="fas fa-eye-slash text-gray-400"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column - Avatar Upload -->
                        <div class="space-y-4">
                            <!-- Current Avatar -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Avatar Saat Ini</label>
                                <div class="flex items-center space-x-4">
                                    @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                                    @else
                                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-200">
                                        <i class="fas fa-user text-gray-400 text-2xl"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="text-sm text-gray-600">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- New Avatar Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Avatar Baru (Opsional)</label>
                                <div x-data="imageUploader()" class="space-y-4">
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                        <template x-if="!preview">
                                            <div>
                                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                                <p class="text-gray-600 mb-2">Pilih gambar baru jika ingin mengubah avatar</p>
                                                <button type="button" 
                                                        @click="$refs.fileInput.click()"
                                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                                    Pilih File
                                                </button>
                                            </div>
                                        </template>

                                        <template x-if="preview">
                                            <div class="relative">
                                                <img :src="preview" alt="Preview" class="w-32 h-32 mx-auto rounded-full object-cover">
                                                <button type="button" 
                                                        @click="preview = null; $refs.fileInput.value = ''"
                                                        class="absolute top-0 right-0 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </template>
                                    </div>

                                    <input type="file" 
                                           x-ref="fileInput"
                                           name="avatar" 
                                           accept="image/*"
                                           @change="updatePreview($event.target.files[0])"
                                           class="hidden">
                                </div>
                                @error('avatar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- User Stats -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Informasi User:</h4>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <div class="flex justify-between">
                                        <span>Bergabung:</span>
                                        <span>{{ $user->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Terakhir update:</span>
                                        <span>{{ $user->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @if($user->id === auth()->id())
                                    <div class="text-green-600 font-medium">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Ini adalah akun Anda saat ini
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('users.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-medium transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fas fa-eye text-gray-400';
            } else {
                field.type = 'password';
                icon.className = 'fas fa-eye-slash text-gray-400';
            }
        }
    </script>
    @endpush
</x-app-layout>