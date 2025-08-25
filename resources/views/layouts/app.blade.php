<!DOCTYPE html>
<html lang="id" class="{{ $appSettings['theme'] ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', app_title()) - {{ app_name() }}</title>
    <link rel="icon" href="{{ app_favicon() }}" type="image/x-icon">
    
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Dynamic theme styles -->
    <style>
        /* 🎨 Theme Variables */
     :root {
  --bg-color: #f9fafb;   /* background umum */
  --panel-color: #ffffff;
  --card-bg: #ffffff;    /* untuk card/dashboard panel */
  --text-color: #111827;
  --primary-color: #2563eb;

  --success-color: #16a34a;
  --warning-color: #fb923c;
  --danger-color: #ef4444;
}

/* Dark Theme */
.theme-dark {
  --bg-color: #111827;
  --panel-color: #1f2937;
  --card-bg: #1f2937;
  --text-color: #f9fafb;
  --primary-color: #2563eb;

  --success-color: #22c55e;
  --warning-color: #facc15;
  --danger-color: #f87171;
}

/* Green Theme */
.theme-green {
  --bg-color: #ecfdf5;
  --panel-color: #f0fdf4;
  --card-bg: #d1fae5;
  --text-color: #064e3b;
  --primary-color: #16a34a;

  --success-color: #15803d;
  --warning-color: #ca8a04;
  --danger-color: #dc2626;
}

/* Blue Theme */
.theme-blue {
  --bg-color: #eff6ff;
  --panel-color: #ffffff;
  --card-bg: #dbeafe;
  --text-color: #1e3a8a;
  --primary-color: #2563eb;

  --success-color: #15803d;
  --warning-color: #ea580c;
  --danger-color: #dc2626;
}


        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            transition: background 0.3s, color 0.3s;
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            border-right: 3px solid var(--primary-color);
            color: var(--primary-color);
        }

.stat-card, .dashboard-panel, .quick-action {
    background: var(--card-bg);
    color: var(--text-color);
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}
        
        .stat-card:hover, .dashboard-panel:hover, .quick-action:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
            box-shadow: 0 16px 25px -5px rgba(59, 130, 246, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
    </style>
    
    @yield('styles')
</head>
<body class="text-gray-800 {{ $appSettings['theme'] === 'dark' ? 'bg-gray-900 text-gray-100' : 'bg-white text-gray-800' }}">
    <div class="flex min-h-screen">
        <!-- Sidebar (akan diisi berdasarkan role) -->
        @includeWhen(Auth::check(), 'layouts.sidebars.' . Auth::user()->role->name)

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Mobile Header -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center md:hidden">
                <button id="mobile-menu-button" class="p-2 rounded-md text-gray-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-md">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Structure (akan diisi berdasarkan role) -->
    @includeWhen(Auth::check(), 'layouts.mobile-sidebars.' . Auth::user()->role->name)

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile menu functionality
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            document.getElementById('mobile-sidebar').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('sidebar-content').classList.remove('-translate-x-full');
            }, 50);
        });

        document.getElementById('close-sidebar')?.addEventListener('click', function() {
            document.getElementById('sidebar-content').classList.add('-translate-x-full');
            setTimeout(() => {
                document.getElementById('mobile-sidebar').classList.add('hidden');
            }, 300);
        });
    </script>
    
    @yield('scripts')
</body>
</html>
