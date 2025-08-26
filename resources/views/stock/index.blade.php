@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')
<div class="container py-6">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold mb-1" style="font-size: 2rem;">
                <i class="fas fa-boxes-stacked me-2 text-primary"></i>Manajemen Stok
            </h1>
            <p class="text-muted mb-0">Kelola transaksi masuk dan keluar stok produk</p>
        </div>
        <a href="{{ route('stocks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Tambah Transaksi
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Card Daftar Transaksi Stok -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <span><i class="fas fa-list me-2"></i>Daftar Transaksi Stok</span>
                    <span class="badge bg-primary">{{ $transactions->count() }} Transaksi</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                        <table class="table table-hover mb-0">
                            <thead class="table-light position-sticky top-0">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Petugas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $t)
                                    <tr>
                                        <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
                                        <td class="fw-semibold">{{ $t->product->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $t->type == 'masuk' ? 'success' : 'danger' }}">
                                                <i class="fas fa-{{ $t->type == 'masuk' ? 'arrow-down' : 'arrow-up' }} me-1"></i>{{ ucfirst($t->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-{{ $t->type == 'masuk' ? 'success' : 'danger' }}">
                                                {{ $t->type == 'masuk' ? '+' : '-' }}{{ $t->quantity }}
                                            </span>
                                        </td>
                                        <td>{{ $t->user->name ?? 'System' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('stocks.edit', $t->id) }}" class="btn btn-sm btn-warning me-1">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                <form action="{{ route('stocks.destroy', $t->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus transaksi ini?')">
                                                        <i class="fas fa-trash me-1"></i>Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                            <div class="fw-bold text-muted">Belum ada transaksi</div>
                                            <small class="text-muted">Silakan tambahkan transaksi stok pertama Anda</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Riwayat Aktivitas -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <span><i class="fas fa-history me-2"></i>Riwayat Aktivitas</span>
                    <span class="badge bg-info">10 Terbaru</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="table-light position-sticky top-0">
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
                                        <td><span class="badge bg-secondary">{{ $log->action }}</span></td>
                                        <td>{{ $log->details }}</td>
                                        <td>{{ $log->user->name ?? 'System' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="fas fa-clipboard-list fa-2x text-muted mb-2"></i>
                                            <div class="fw-bold text-muted">Belum ada riwayat aktivitas</div>
                                            <small class="text-muted">Riwayat aktivitas akan muncul di sini</small>
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
@endsection
