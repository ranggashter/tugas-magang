<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-gradient {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 15px 15px;
        }
        .card-custom {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            height: 100%;
        }
        .card-header-custom {
            background-color: #f1f5fd;
            border-bottom: 1px solid #e3e9f7;
            font-weight: 600;
            font-size: 1.25rem;
            padding: 1.25rem 1.5rem;
        }
        .card-body-custom {
            padding: 1.5rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .table-container {
            overflow-y: auto;
            flex-grow: 1;
            max-height: 400px;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            padding: 1rem 0.75rem;
            font-size: 1.05rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            font-size: 1.05rem;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(37, 117, 252, 0.05);
        }
        .badge {
            padding: 0.5em 0.75em;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.95rem;
        }
        .btn-action {
            padding: 0.5rem 0.85rem;
            font-size: 0.95rem;
            border-radius: 6px;
            margin: 0 3px;
            white-space: nowrap;
        }
        .btn-add {
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(37, 117, 252, 0.3);
            font-size: 1.05rem;
        }
        .alert-custom {
            font-size: 1.1rem;
            padding: 1rem 1.25rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .transaction-type-badge {
            font-size: 0.9rem;
            padding: 0.5rem 0.8rem;
        }
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }
        .empty-state h5 {
            font-size: 1.4rem;
        }
        .empty-state p {
            font-size: 1.1rem;
        }
        .log-table {
            font-size: 0.95rem;
        }
        .log-table thead th {
            font-size: 1rem;
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
        }
        .card-height {
            min-height: 500px;
        }
        /* Scrollbar styling */
        .table-container::-webkit-scrollbar {
            width: 8px;
        }
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>
<body>
    <div class="header-gradient">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-0" style="font-size: 2.1rem;"><i class="fas fa-boxes-stacked me-2"></i>Manajemen Stok</h1>
                    <p class="mb-0 mt-1 opacity-75" style="font-size: 1.1rem;">Kelola transaksi masuk dan keluar stok produk</p>
                </div>
                <a href="{{ route('stocks.create') }}" class="btn btn-light btn-add">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Transaksi
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert-custom alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert-custom alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Card 1: Daftar Transaksi Stok -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card-custom card-height">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-list me-2"></i>Daftar Transaksi Stok</span>
                        <span class="badge bg-primary">{{ $transactions->count() }} Transaksi</span>
                    </div>
                    <div class="card-body-custom">
                        <div class="table-container">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Produk</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th>Petugas</th>
                                        <th width="180" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $t)
                                        <tr>
                                            <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
                                            <td class="fw-semibold">{{ $t->product->name ?? '-' }}</td>
                                            <td>
                                                <span class="badge transaction-type-badge bg-{{ $t->type == 'masuk' ? 'success' : 'danger' }}">
                                                    <i class="fas fa-{{ $t->type == 'masuk' ? 'arrow-down' : 'arrow-up' }} me-1"></i>
                                                    {{ ucfirst($t->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold {{ $t->type == 'masuk' ? 'text-success' : 'text-danger' }}">
                                                    {{ $t->type == 'masuk' ? '+' : '-' }}{{ $t->quantity }}
                                                </span>
                                            </td>
                                            <td>{{ $t->user->name ?? 'System' }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('stocks.edit', $t->id) }}" class="btn btn-warning btn-action">
                                                        <i class="fas fa-edit me-1"></i>Edit
                                                    </a>
                                                    <form action="{{ route('stocks.destroy', $t->id) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-action ms-2" onclick="return confirm('Hapus transaksi ini?')">
                                                            <i class="fas fa-trash me-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state py-4">
                                                    <i class="fas fa-inbox"></i>
                                                    <h5 class="mt-2">Belum ada transaksi</h5>
                                                    <p>Silakan tambahkan transaksi stok pertama Anda</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Riwayat Transaksi Stok (Log) -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card-custom card-height">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-history me-2"></i>Riwayat Aktivitas</span>
                        <span class="badge bg-info">10 Terbaru</span>
                    </div>
                    <div class="card-body-custom">
                        <div class="table-container">
                            <table class="table table-sm table-hover log-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Aktivitas</th>
                                        <th>Detail</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(\App\Models\ActivityLog::latest()->take(10)->get() as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $log->action }}</span>
                                            </td>
                                            <td>{{ $log->details }}</td>
                                            <td>{{ $log->user->name ?? 'System' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="empty-state py-4">
                                                    <i class="fas fa-clipboard-list"></i>
                                                    <h5 class="mt-2">Belum ada riwayat aktivitas</h5>
                                                    <p>Riwayat aktivitas akan muncul di sini</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>