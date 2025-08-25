@php
    $themes = [
        'light' => [
            'sidebar' => 'bg-white text-gray-800 border-r border-gray-200',
            'header' => 'border-gray-100',
            'link' => 'text-gray-500 hover:bg-blue-50 hover:text-blue-600',
            'active' => 'text-blue-600 bg-blue-50',
            'icon' => 'text-blue-600',
        ],
        'dark' => [
            'sidebar' => 'bg-gray-900 text-gray-100 border-r border-gray-700',
            'header' => 'border-gray-700',
            'link' => 'text-gray-400 hover:bg-gray-800 hover:text-white',
            'active' => 'text-blue-400 bg-gray-800',
            'icon' => 'text-blue-400',
        ],
        'blue' => [
            'sidebar' => 'bg-blue-900 text-white border-r border-blue-700',
            'header' => 'border-blue-700',
            'link' => 'text-blue-100 hover:bg-blue-800 hover:text-white',
            'active' => 'bg-blue-800 text-white',
            'icon' => 'text-white',
        ],
        'green' => [
            'sidebar' => 'bg-green-900 text-white border-r border-green-700',
            'header' => 'border-green-700',
            'link' => 'text-green-100 hover:bg-green-800 hover:text-white',
            'active' => 'bg-green-800 text-white',
            'icon' => 'text-white',
        ],
    ];
    $theme = $themes[$appSettings['theme'] ?? 'light'];
@endphp

<!-- Sidebar Admin -->
<aside class="w-72 shadow-xl z-10 hidden md:block {{ $theme['sidebar'] }}">
    <!-- Header Logo + Title -->
    <div class="flex items-center space-x-4 p-6 border-b {{ $theme['header'] }}">
        <!-- Logo -->
        <div class="w-16 h-16 flex items-center justify-center rounded-xl shadow-md overflow-hidden bg-white">
            @if(setting('logo'))
                <img src="{{ app_logo() }}" alt="Logo" class="w-full h-full object-contain">
            @else
                <i class="fas fa-boxes text-3xl text-blue-600"></i>
            @endif
        </div>

        <!-- Nama Aplikasi -->
        <div>
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">
                {{ app_name() ?? 'Stockify' }}
            </h1>
            <p class="text-lg opacity-80">Admin System</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6 space-y-1">
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-6 py-3 rounded-lg font-semibold text-lg
                  {{ request()->routeIs('admin.dashboard') ? $theme['active'] : $theme['link'] }}">
            <i class="fas fa-th-large mr-3 {{ $theme['icon'] }}"></i>
            Dashboard
        </a>
        <a href="{{ route('products.index') }}" 
           class="flex items-center px-6 py-3 rounded-lg text-lg
                  {{ request()->routeIs('products.*') ? $theme['active'] : $theme['link'] }}">
            <i class="fas fa-box mr-3 {{ $theme['icon'] }}"></i>
            Produk
        </a>
        <a href="{{ route('categories.index') }}" 
           class="flex items-center px-6 py-3 rounded-lg text-lg
                  {{ request()->routeIs('categories.*') ? $theme['active'] : $theme['link'] }}">
            <i class="fas fa-tags mr-3 {{ $theme['icon'] }}"></i>
            Kategori
        </a>
        <a href="{{ route('suppliers.index') }}" 
           class="flex items-center px-6 py-3 rounded-lg text-lg
                  {{ request()->routeIs('suppliers.*') ? $theme['active'] : $theme['link'] }}">
            <i class="fas fa-truck-loading mr-3 {{ $theme['icon'] }}"></i>
            Supplier
        </a>
        <a href="{{ route('stocks.index') }}" 
           class="flex items-center px-6 py-3 rounded-lg text-lg
                  {{ request()->routeIs('stocks.*') ? $theme['active'] : $theme['link'] }}">
            <i class="fas fa-boxes mr-3 {{ $theme['icon'] }}"></i>
            Stok
        </a>

        <!-- Reports Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-6 py-3 rounded-lg text-lg {{ $theme['link'] }}">
                <div class="flex items-center">
                    <i class="fas fa-chart-bar mr-3 {{ $theme['icon'] }}"></i>
                    Laporan
                </div>
                <i class="fas fa-chevron-down text-sm transition-transform duration-200" 
                   :class="open ? 'rotate-180' : ''"></i>
            </button>
            
            <div x-show="open" x-transition class="ml-8 mt-1 space-y-2">
                <a href="{{ route('reports.activity') }}" class="block px-4 py-2 rounded-md text-base {{ $theme['link'] }}">
                    <i class="fas fa-chart-line mr-2"></i>Aktivitas
                </a>
                <a href="{{ route('reports.stock') }}" class="block px-4 py-2 rounded-md text-base {{ $theme['link'] }}">
                    <i class="fas fa-boxes mr-2"></i>Stok
                </a>
                <a href="{{ route('reports.transactions') }}" class="block px-4 py-2 rounded-md text-base {{ $theme['link'] }}">
                    <i class="fas fa-exchange-alt mr-2"></i>Transaksi
                </a>
            </div>
        </div>
        
        <a href="{{ route('users.index') }}" 
           class="flex items-center px-6 py-3 rounded-lg text-lg
                  {{ request()->routeIs('users.*') ? $theme['active'] : $theme['link'] }}">
            <i class="fas fa-users-cog mr-3 {{ $theme['icon'] }}"></i>
            Kelola Akun
        </a>
        <a href="{{ route('settings.index') }}" 
           class="flex items-center px-6 py-3 rounded-lg text-lg
                  {{ request()->routeIs('settings.*') ? $theme['active'] : $theme['link'] }}">
            <i class="fas fa-gear mr-3 {{ $theme['icon'] }}"></i>
            Pengaturan
        </a>
        
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-6 px-6">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-2 text-lg text-red-600 hover:bg-red-50 rounded-md">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Logout
            </button>
        </form>
    </nav>
</aside>
