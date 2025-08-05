<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Al-Ruhamaa Inventory') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-green { background: #047857; }
        .sidebar-green-dark { background: #065f46; }
        .nav-item:hover { background: #065f46; }
        .active-nav-link { background: #065f46; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="sidebar-green h-screen w-64 hidden lg:block shadow-xl fixed z-30">
            <!-- Logo & Brand -->
            <div class="p-6 border-b border-green-600">
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
            <nav class="text-white text-sm font-medium pt-4 h-[calc(100vh-180px)] overflow-y-auto">
                <!-- Dashboard - Semua user yang login -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center text-white py-3 px-6 nav-item {{ request()->routeIs('dashboard') ? 'active-nav-link' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 w-4"></i>
                    Dashboard
                </a>

                <!-- User Management - Hanya Admin -->
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('users.index') }}" 
                   class="flex items-center text-white py-3 px-6 nav-item {{ request()->routeIs('users.*') ? 'active-nav-link' : '' }}">
                    <i class="fas fa-users mr-3 w-4"></i>
                    Manajemen User
                </a>
                @endif

                <!-- Product Management - Manager dan Admin -->
                @if(in_array(Auth::user()->role, ['manager', 'admin']))
                <a href="{{ route('products.index') }}" 
                   class="flex items-center text-white py-3 px-6 nav-item {{ request()->routeIs('products.*') ? 'active-nav-link' : '' }}">
                    <i class="fas fa-box mr-3 w-4"></i>
                    Produk
                </a>
                @endif

                <!-- Menu lainnya untuk semua role -->
                <a href="#" class="flex items-center text-white py-3 px-6 nav-item">
                    <i class="fas fa-tags mr-3 w-4"></i>
                    Kategori Produk
                </a>

                <a href="#" class="flex items-center text-white py-3 px-6 nav-item">
                    <i class="fas fa-warehouse mr-3 w-4"></i>
                    Inventory
                </a>

                <a href="#" class="flex items-center text-white py-3 px-6 nav-item">
                    <i class="fas fa-truck mr-3 w-4"></i>
                    Supplier
                </a>

                @if(in_array(Auth::user()->role, ['manager', 'admin']))
                <a href="#" class="flex items-center text-white py-3 px-6 nav-item">
                    <i class="fas fa-chart-line mr-3 w-4"></i>
                    Laporan
                </a>
                @endif
            </nav>

            <!-- User Profile Section -->
            <div class="absolute bottom-0 w-64">
                <div class="sidebar-green-dark p-4 border-t border-green-600">
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

        <!-- Mobile Sidebar -->
        <div x-data="{ sidebarOpen: false }" class="lg:hidden">
            <!-- Mobile menu button -->
            <div class="fixed top-0 left-0 right-0 bg-white shadow-sm z-40 lg:hidden">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center space-x-3">
                        <img src="https://yatimcenter-alruhamaa.org/assets/images/logo/icon-white.png" 
                             alt="Al-Ruhamaa Logo" 
                             class="w-8 h-8 object-contain">
                        <h1 class="text-gray-900 font-bold">Al-Ruhamaa'</h1>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" @click.away="sidebarOpen = false" 
                 class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden">
                <aside class="sidebar-green h-full w-64 shadow-xl">
                    <div class="p-6 border-b border-green-600">
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
                    
                    <nav class="text-white text-sm font-medium pt-4">
                        <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                           class="flex items-center text-white py-3 px-6 nav-item">
                            <i class="fas fa-tachometer-alt mr-3 w-4"></i>Dashboard
                        </a>
                        
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('users.index') }}" @click="sidebarOpen = false"
                           class="flex items-center text-white py-3 px-6 nav-item">
                            <i class="fas fa-users mr-3 w-4"></i>Manajemen User
                        </a>
                        @endif

                        @if(in_array(Auth::user()->role, ['manager', 'admin']))
                        <a href="{{ route('products.index') }}" @click="sidebarOpen = false"
                           class="flex items-center text-white py-3 px-6 nav-item">
                            <i class="fas fa-box mr-3 w-4"></i>Produk
                        </a>
                        @endif
                    </nav>
                </aside>
            </div>
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 lg:ml-64">
            <div class="h-16 lg:hidden"></div>

            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <div class="p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- AlpineJS -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Image uploader function -->
    <script>
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