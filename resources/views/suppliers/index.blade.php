<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Supplier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#64748b',
                        success: '#22c55e',
                        danger: '#ef4444',
                        warning: '#f59e0b',
                        info: '#3b82f6'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        .header-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1e293b;
        }
        .btn {
            font-size: 1.05rem;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .table-container {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .table-header {
            background-color: #1e40af;
            color: white;
            font-size: 1.125rem;
        }
        .table-cell {
            font-size: 1.075rem;
            padding: 1rem 1.5rem;
        }
        .supplier-name {
            font-weight: 500;
            font-size: 1.1rem;
        }
        .action-btn {
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            margin-right: 0.5rem;
        }
        .alert-success {
            font-size: 1.1rem;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
        }
        .contact-info {
            color: #64748b;
        }
    </style>
</head>
<body class="p-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="header-title">
                <i class="fas fa-truck mr-3 text-blue-600"></i>Daftar Supplier
            </h1>
            <a href="{{ route('suppliers.create') }}" class="btn bg-blue-600 text-white hover:bg-blue-700">
                <i class="fas fa-plus-circle mr-2"></i>Tambah Supplier
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success bg-green-100 text-green-800 border-l-4 border-green-500 mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="table-auto w-full bg-white">
                <thead>
                    <tr class="table-header">
                        <th class="table-cell text-left">Nama Supplier</th>
                        <th class="table-cell text-left">Kontak</th>
                        <th class="table-cell text-left">Alamat</th>
                        <th class="table-cell text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $s)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="table-cell border-t">
                            <div class="supplier-name">{{ $s->name }}</div>
                        </td>
                        <td class="table-cell border-t">
                            <div class="contact-info">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-envelope mr-2 text-blue-500"></i>
                                    {{ $s->email ?? '-' }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-green-500"></i>
                                    {{ $s->phone ?? '-' }}
                                </div>
                            </div>
                        </td>
                        <td class="table-cell border-t">
                            <div class="contact-info">
                                {{ $s->address ?? '-' }}
                            </div>
                        </td>
                        <td class="table-cell border-t text-center">
                            <div class="flex justify-center">
                                <a href="{{ route('suppliers.edit', $s->id) }}" class="action-btn bg-yellow-400 text-gray-800 hover:bg-yellow-500">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn bg-red-500 text-white hover:bg-red-600 ml-2" onclick="return confirm('Hapus supplier?')">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(count($suppliers) == 0)
                    <tr>
                        <td colspan="4" class="table-cell border-t text-center">
                            <div class="py-8 text-gray-500">
                                <i class="fas fa-truck-loading text-4xl mb-4"></i>
                                <p class="text-xl">Belum ada supplier</p>
                                <p class="mt-2">Silakan tambahkan supplier pertama Anda</p>
                                <a href="{{ route('suppliers.create') }}" class="btn bg-blue-600 text-white hover:bg-blue-700 mt-4 inline-block">
                                    <i class="fas fa-plus-circle mr-2"></i>Tambah Supplier
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>