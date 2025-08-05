<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Al-Ruhamaa Inventory') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-green { background: linear-gradient(135deg, #047857 0%, #065f46 100%); }
        .sidebar-green-dark { background: #065f46; }
        .nav-item:hover { background: rgba(255,255,255,0.1); border-radius: 8px; margin: 2px 8px; }
        .active-nav-link { background: rgba(255,255,255,0.15); border-radius: 8px; margin: 2px 8px; border-left: 3px solid #10b981; }
        
        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }
        
        /* Toast Notification */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            padding: 16px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transform: translateX(500px);
            transition: transform 0.3s ease-in-out;
        }
        
        .toast.show {
            transform: translateX(0);
        }
        
        .toast-success { background: #f0fdf4; border-left: 4px solid #22c55e; color: #166534; }
        .toast-error { background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; }
        .toast-warning { background: #fffbeb; border-left: 4px solid #f59e0b; color: #92400e; }
        .toast-info { background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; }
        
        /* DataTable Custom Styling */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 6px;
            border: 1px solid #d1d5db;
            padding: 6px 12px;
        }
        
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 12px;
        }
        
        /* Notification Panel */
        .notification-panel {
            position: fixed;
            top: 0;
            right: -400px;
            width: 380px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            transition: right 0.3s ease-in-out;
            z-index: 9998;
        }
        
        .notification-panel.show {
            right: 0;
        }
        
        .notification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9997;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out;
        }
        
        .notification-overlay.show {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Toast Container -->
    <div id="toast-container"></div>
    
    <!-- Notification Overlay -->
    <div id="notification-overlay" class="notification-overlay"></div>
    
    <!-- Notification Panel -->
    <div id="notification-panel" class="notification-panel">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Notifikasi</h3>
                <button onclick="closeNotificationPanel()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="p-4 space-y-3 overflow-y-auto h-full">
            <div id="notification-list">
                <!-- Notifications will be loaded here -->
            </div>
        </div>
    </div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="sidebar-green h-screen w-64 hidden lg:block shadow-xl fixed z-30">
            <!-- Logo & Brand -->
            <div class="p-6 border-b border-green-600/20">
                <div class="flex items-center gap-3">
                    <img src="https://yatimcenter-alruhamaa.org/assets/images/logo/icon-white.png" 
                         alt="Al-Ruhamaa Logo" 
                         class="w-10 h-10 object-contain">
                    <div>
                        <h1 class="text-white font-bold text-lg">Al-Ruhamaa'</h1>
                        <p class="text-green-200 text-xs">Inventory System</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="text-white text-sm font-medium pt-4 h-[calc(100vh-180px)] overflow-y-auto px-2">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center text-white py-3 px-4 nav-item {{ request()->routeIs('dashboard') ? 'active-nav-link' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 w-4"></i>
                    Dashboard
                </a>

                <!-- User Management - Admin Only -->
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('users.index') }}" 
                   class="flex items-center text-white py-3 px-4 nav-item {{ request()->routeIs('users.*') ? 'active-nav-link' : '' }}">
                    <i class="fas fa-users mr-3 w-4"></i>
                    Manajemen User
                </a>
                @endif

                <!-- Product Management - Manager & Admin -->
                @if(in_array(Auth::user()->role, ['manager', 'admin']))
                <a href="{{ route('products.index') }}" 
                   class="flex items-center text-white py-3 px-4 nav-item {{ request()->routeIs('products.*') ? 'active-nav-link' : '' }}">
                    <i class="fas fa-box mr-3 w-4"></i>
                    Produk
                </a>
                @endif

                <!-- Other Menu Items -->
                <a href="#" class="flex items-center text-white py-3 px-4 nav-item">
                    <i class="fas fa-tags mr-3 w-4"></i>
                    Kategori
                </a>

                <a href="#" class="flex items-center text-white py-3 px-4 nav-item">
                    <i class="fas fa-warehouse mr-3 w-4"></i>
                    Inventory
                </a>

                <a href="#" class="flex items-center text-white py-3 px-4 nav-item">
                    <i class="fas fa-truck mr-3 w-4"></i>
                    Supplier
                </a>

                @if(in_array(Auth::user()->role, ['manager', 'admin']))
                <a href="#" class="flex items-center text-white py-3 px-4 nav-item">
                    <i class="fas fa-chart-line mr-3 w-4"></i>
                    Laporan
                </a>
                @endif
            </nav>

            <!-- User Profile Section -->
            <div class="absolute bottom-0 w-64">
                <div class="sidebar-green-dark p-4 border-t border-green-600/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-green-800 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                                <p class="text-green-200 text-xs capitalize">{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                        
                        <!-- Dropdown Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-green-200 hover:text-white">
                                <i class="fas fa-chevron-up text-xs"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute bottom-full right-0 mb-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-cog mr-2"></i>Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 lg:ml-64">
            <!-- Top Header Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden text-gray-600" onclick="toggleMobileSidebar()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-md mx-4">
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Cari di sistem..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notification Bell -->
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button onclick="toggleNotificationPanel()" 
                                    class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg relative">
                                <i class="fas fa-bell text-xl"></i>
                                <span id="notification-badge" class="notification-badge hidden">3</span>
                            </button>
                        </div>
                        
                        <!-- Current Time -->
                        <div class="hidden md:block text-sm text-gray-600">
                            <div id="current-time"></div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Header -->
            @isset($header)
                <div class="bg-white border-b border-gray-200">
                    <div class="px-6 py-4">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <!-- Page Content -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <!-- AlpineJS -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Custom Scripts -->
    <script>
        // Current Time Update
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString;
        }
        
        setInterval(updateTime, 1000);
        updateTime();

        // Toast Notification Function
        function showToast(message, type = 'success', duration = 5000) {
            const toastContainer = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle'
            };
            
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div class="flex items-start">
                    <i class="${icons[type]} text-lg mr-3 mt-0.5"></i>
                    <div class="flex-1">
                        <p class="font-medium">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Show toast
            setTimeout(() => toast.classList.add('show'), 100);
            
            // Auto remove
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }

        // Notification Panel Functions
        function toggleNotificationPanel() {
            const panel = document.getElementById('notification-panel');
            const overlay = document.getElementById('notification-overlay');
            
            panel.classList.toggle('show');
            overlay.classList.toggle('show');
            
            if (panel.classList.contains('show')) {
                loadNotifications();
            }
        }
        
        function closeNotificationPanel() {
            document.getElementById('notification-panel').classList.remove('show');
            document.getElementById('notification-overlay').classList.remove('show');
        }
        
        function loadNotifications() {
            const notificationList = document.getElementById('notification-list');
            
            // Simulate loading notifications
            const notifications = [
                {
                    title: 'User Baru Ditambahkan',
                    message: 'Admin menambahkan user "John Doe" ke sistem',
                    time: '2 menit yang lalu',
                    type: 'success',
                    icon: 'fas fa-user-plus'
                },
                {
                    title: 'Stok Menipis',
                    message: 'Beras Premium 5kg tersisa 5 unit',
                    time: '15 menit yang lalu',
                    type: 'warning',
                    icon: 'fas fa-exclamation-triangle'
                },
                {
                    title: 'Barang Masuk',
                    message: 'Received 100 units of Minyak Goreng 2L',
                    time: '1 jam yang lalu',
                    type: 'info',
                    icon: 'fas fa-arrow-down'
                }
            ];
            
            notificationList.innerHTML = notifications.map(notif => `
                <div class="p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-${notif.type === 'success' ? 'green' : notif.type === 'warning' ? 'yellow' : 'blue'}-100 flex items-center justify-center">
                                <i class="${notif.icon} text-${notif.type === 'success' ? 'green' : notif.type === 'warning' ? 'yellow' : 'blue'}-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">${notif.title}</p>
                            <p class="text-xs text-gray-500 mt-1">${notif.message}</p>
                            <p class="text-xs text-gray-400 mt-1">${notif.time}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Show notification badge
        document.getElementById('notification-badge').classList.remove('hidden');

        // Close notification panel when clicking overlay
        document.getElementById('notification-overlay').addEventListener('click', closeNotificationPanel);

        // Show toast for session messages
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif

        @if(session('warning'))
            showToast('{{ session('warning') }}', 'warning');
        @endif

        @if(session('info'))
            showToast('{{ session('info') }}', 'info');
        @endif

        // Image uploader function
        function imageUploader() {
            return {
                preview: null,
                dragging: false,

                init() {
                    this.preview = null;
                },

                updatePreview(file) {
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = e => this.preview = e.target.result;
                        reader.readAsDataURL(file);
                    } else {
                        this.preview = null;
                    }
                },

                handleDrop(e) {
                    this.dragging = false;
                    const file = e.dataTransfer.files[0];
                    if (file) {
                        this.$refs.fileInput.files = e.dataTransfer.files;
                        this.updatePreview(file);
                    }
                }
            };
        }
    </script>

    @stack('scripts')
</body>
</html>