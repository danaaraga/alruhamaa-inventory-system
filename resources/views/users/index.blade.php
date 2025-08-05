<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen User</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola akun pengguna sistem inventory</p>
            </div>
            <a href="{{ route('users.create') }}" 
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>Tambah User
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[['title' => 'Manajemen User']]" />

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Users Card -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-6 rounded-xl shadow-sm border border-emerald-200 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-emerald-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-emerald-700">Total User</p>
                        <p class="text-2xl font-bold text-emerald-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Admin Card -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-sm border border-purple-200 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="fas fa-crown text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-purple-700">Admin</p>
                        <p class="text-2xl font-bold text-purple-900">{{ $stats['admin'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Manager Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-sm border border-blue-200 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="fas fa-user-tie text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-700">Manager</p>
                        <p class="text-2xl font-bold text-blue-900">{{ $stats['manager'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Staff Card -->
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-6 rounded-xl shadow-sm border border-teal-200 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-teal-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-teal-700">Staff</p>
                        <p class="text-2xl font-bold text-teal-900">{{ $stats['staff'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold">Daftar User</h2>
                        <p class="text-emerald-100 text-sm mt-1">Kelola semua pengguna sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button id="bulk-delete-btn" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-md hover:shadow-lg"
                                disabled>
                            <i class="fas fa-trash mr-2"></i>Hapus (<span id="selected-count">0</span>)
                        </button>
                        <a href="{{ route('users.export') }}" 
                           class="bg-white text-emerald-700 hover:bg-emerald-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-download mr-2"></i>Export
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-gray-50 p-4 border-b border-gray-200">
                <form method="GET" action="{{ route('users.index') }}" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-2 md:space-y-0">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari berdasarkan nama atau email..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <select name="role" 
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white min-w-[120px]">
                            <option value="all" {{ request('role') === 'all' ? 'selected' : '' }}>Semua Role</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ request('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex space-x-2">
                        <button type="submit" 
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        <a href="{{ route('users.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-times mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="p-6">
                <form id="bulk-delete-form" method="POST" action="{{ route('users.bulk-delete') }}">
                    @csrf
                    @method('DELETE')
                    
                    <!-- Table Container with Custom Scroll -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-100 to-gray-200 border-b-2 border-emerald-500">
                                    <th class="text-left py-4 px-3 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    </th>
                                    <th class="text-left py-4 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">User</th>
                                    <th class="text-left py-4 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">Email</th>
                                    <th class="text-left py-4 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">Role</th>
                                    <th class="text-left py-4 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">Status</th>
                                    <th class="text-left py-4 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">Bergabung</th>
                                    <th class="text-center py-4 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr class="border-b border-gray-100 hover:bg-emerald-50 transition-colors duration-150">
                                    <td class="py-4 px-3">
                                        @if($user->id !== auth()->id())
                                        <input type="checkbox" 
                                               name="user_ids[]" 
                                               value="{{ $user->id }}" 
                                               class="user-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10">
                                                @if($user->avatar)
                                                <img class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-200" 
                                                     src="{{ asset('storage/' . $user->avatar) }}" 
                                                     alt="{{ $user->name }}">
                                                @else
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-500"></i>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-semibold text-gray-900">
                                                    {{ $user->name }}
                                                    @if($user->id === auth()->id())
                                                    <span class="text-xs bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-medium ml-2">
                                                        <i class="fas fa-user-circle mr-1"></i>Anda
                                                    </span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <p class="text-sm text-gray-700">{{ $user->email }}</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        @php
                                            $roleData = [
                                                'admin' => [
                                                    'bg' => 'bg-gradient-to-r from-purple-100 to-purple-200',
                                                    'text' => 'text-purple-800',
                                                    'icon' => 'fas fa-crown',
                                                    'border' => 'border-purple-300'
                                                ],
                                                'manager' => [
                                                    'bg' => 'bg-gradient-to-r from-blue-100 to-blue-200',
                                                    'text' => 'text-blue-800',
                                                    'icon' => 'fas fa-user-tie',
                                                    'border' => 'border-blue-300'
                                                ],
                                                'staff' => [
                                                    'bg' => 'bg-gradient-to-r from-teal-100 to-teal-200',
                                                    'text' => 'text-teal-800',
                                                    'icon' => 'fas fa-user',
                                                    'border' => 'border-teal-300'
                                                ],
                                            ];
                                            $role = $roleData[$user->role] ?? $roleData['staff'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $role['bg'] }} {{ $role['text'] }} {{ $role['border'] }}">
                                            <i class="{{ $role['icon'] }} mr-1.5"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-800 border border-emerald-300">
                                            <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></div>
                                            Aktif
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">{{ $user->created_at->format('d M Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('users.show', $user) }}" 
                                               class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all duration-200"
                                               title="Detail">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" 
                                               class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                               title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            @if($user->id !== auth()->id())
                                            <button onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')" 
                                                    type="button"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                    title="Hapus">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                            @else
                                            <span class="inline-flex items-center justify-center w-8 h-8 text-gray-300 cursor-not-allowed" 
                                                  title="Tidak dapat menghapus akun sendiri">
                                                <i class="fas fa-lock text-sm"></i>
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada user</h3>
                                            <p class="text-gray-500 mb-4">Mulai dengan menambahkan user pertama Anda.</p>
                                            <a href="{{ route('users.create') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                                <i class="fas fa-plus mr-2"></i>Tambah User
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>

                <!-- Custom Pagination -->
                @if($users->hasPages())
                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user
                    </div>
                    
                    <div class="flex items-center space-x-1">
                        {{-- Previous Page Link --}}
                        @if ($users->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left mr-1"></i>Previous
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" 
                               class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-300 transition-colors">
                                <i class="fas fa-chevron-left mr-1"></i>Previous
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span class="px-3 py-2 text-sm text-white bg-emerald-600 border border-emerald-600 rounded-lg font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" 
                                   class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-300 transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" 
                               class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-300 transition-colors">
                                Next<i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                Next<i class="fas fa-chevron-right ml-1"></i>
                            </span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl shadow-2xl max-w-md w-full mx-4 transform scale-95 transition-all duration-300">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-100 to-red-200 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                    <p class="text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>
            <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus user <strong id="delete-user-name" class="text-red-600"></strong>?</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" 
                        type="button"
                        class="px-5 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-all duration-200 font-medium">
                    Batal
                </button>
                <form id="delete-form" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-5 py-2 rounded-lg transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                        <i class="fas fa-trash mr-2"></i>Hapus User
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Bulk selection functionality
            const selectAllCheckbox = document.getElementById('select-all');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const selectedCount = document.getElementById('selected-count');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            function updateBulkDeleteButton() {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                const count = checkedBoxes.length;
                
                selectedCount.textContent = count;
                bulkDeleteBtn.disabled = count === 0;
                
                // Add visual feedback
                if (count > 0) {
                    bulkDeleteBtn.classList.remove('opacity-50');
                    bulkDeleteBtn.classList.add('animate-pulse');
                } else {
                    bulkDeleteBtn.classList.add('opacity-50');
                    bulkDeleteBtn.classList.remove('animate-pulse');
                }
            }

            // Select all functionality
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    userCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateBulkDeleteButton();
                });
            }

            // Individual checkbox change
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateBulkDeleteButton();
                    
                    const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = checkedCount === userCheckboxes.length;
                        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < userCheckboxes.length;
                    }
                });
            });

            // Bulk delete button click
            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function() {
                    const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                    if (checkedBoxes.length === 0) return;

                    if (confirm(`Apakah Anda yakin ingin menghapus ${checkedBoxes.length} user terpilih?`)) {
                        bulkDeleteForm.submit();
                    }
                });
            }

            // Initial update
            updateBulkDeleteButton();
        });

        // Delete confirmation functions
        function confirmDelete(userId, userName) {
            document.getElementById('delete-user-name').textContent = userName;
            document.getElementById('delete-form').action = `/users/${userId}`;
            const modal = document.getElementById('delete-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Add smooth entrance animation
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Close modal when clicking outside
        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Escape key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
    @endpush
</x-app-layout>