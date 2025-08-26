@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="p-6">
    <!-- Header with Enhanced Animation -->
    <div class="flex justify-between items-center mb-8 fade-in">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight" style="color:var(--text-color)">
                <i class="fas fa-info-circle mr-2" style="color:var(--primary-color)"></i> Detail Produk
            </h1>
            <p class="text-base opacity-80 mt-2" style="color:var(--text-muted)">
                Informasi lengkap tentang produk dalam inventori.
            </p>
        </div>
        <a href="{{ route('products.index') }}" 
           class="px-5 py-3 rounded-xl font-medium shadow-md hover-lift transition-all duration-300 flex items-center"
           style="background:var(--panel-color); color:var(--text-color); border: 1px solid var(--border-color);">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <!-- Product Info -->
    <div class="modern-card p-6 rounded-2xl mb-6 fade-in" style="background:var(--card-bg); animation-delay: 0.2s;">
        <h2 class="text-xl font-semibold mb-6 flex items-center" style="color:var(--text-color)">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background:var(--primary-color); color:white;">
                <i class="fas fa-info"></i>
            </div>
            Informasi Produk
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 rounded-xl" style="background:var(--panel-color);">
                <p class="text-sm mb-2" style="color:var(--text-muted)">Nama Produk</p>
                <p class="font-medium text-lg" style="color:var(--text-color)">{{ $product->name }}</p>
            </div>
            
            <div class="p-4 rounded-xl" style="background:var(--panel-color);">
                <p class="text-sm mb-2" style="color:var(--text-muted)">Kategori</p>
                <p class="font-medium" style="color:var(--text-color)">
                    <span class="px-3 py-1 rounded-full text-xs" 
                          style="background:color-mix(in srgb, var(--primary-color) 10%, transparent); color:var(--primary-color);">
                        {{ $product->category->name ?? '-' }}
                    </span>
                </p>
            </div>
            
            <div class="p-4 rounded-xl" style="background:var(--panel-color);">
                <p class="text-sm mb-2" style="color:var(--text-muted)">Supplier</p>
                <p class="font-medium" style="color:var(--text-color)">{{ $product->supplier->name ?? '-' }}</p>
            </div>
            
            <div class="p-4 rounded-xl" style="background:var(--panel-color);">
                <p class="text-sm mb-2" style="color:var(--text-muted)">Harga</p>
                <p class="font-bold" style="color:var(--primary-color)">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            
            <div class="p-4 rounded-xl" style="background:var(--panel-color);">
                <p class="text-sm mb-2" style="color:var(--text-muted)">Stok Tersedia</p>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold
                    {{ $product->stock > 20 ? 'bg-green-600/20 text-green-400' : 
                       ($product->stock > 0 ? 'bg-yellow-600/20 text-yellow-400' : 'bg-red-600/20 text-red-400') }}">
                    {{ $product->stock }}
                    <i class="fas {{ $product->stock > 20 ? 'fa-check-circle' : ($product->stock > 0 ? 'fa-exclamation-triangle' : 'fa-times-circle') }} ml-1"></i>
                </span>
            </div>
            
            <div class="p-4 rounded-xl" style="background:var(--panel-color);">
                <p class="text-sm mb-2" style="color:var(--text-muted)">ID Produk</p>
                <p class="font-mono text-sm" style="color:var(--text-color)">#{{ $product->id }}</p>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="modern-card p-6 rounded-2xl fade-in" style="background:var(--card-bg); animation-delay: 0.3s;">
        <h2 class="text-xl font-semibold mb-6 flex items-center" style="color:var(--text-color)">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background:var(--primary-color); color:white;">
                <i class="fas fa-history"></i>
            </div>
            Riwayat Stok
        </h2>
        
        @if($product->transactions->isEmpty())
            <div class="text-center py-8 rounded-xl" style="background:var(--panel-color);">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                     style="background:color-mix(in srgb, var(--text-muted) 10%, transparent); color:var(--text-muted);">
                    <i class="fas fa-inbox text-xl"></i>
                </div>
                <p class="font-medium" style="color:var(--text-color)">Belum ada transaksi</p>
                <p class="text-sm mt-1" style="color:var(--text-muted)">Tidak ada riwayat transaksi untuk produk ini</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-xl" style="border: 1px solid var(--border-color);">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background:var(--panel-color);">
                            <th class="p-4 font-semibold text-left" style="color:var(--text-color)">Tanggal</th>
                            <th class="p-4 font-semibold text-left" style="color:var(--text-color)">Jenis</th>
                            <th class="p-4 font-semibold text-left" style="color:var(--text-color)">Jumlah</th>
                            <th class="p-4 font-semibold text-left" style="color:var(--text-color)">Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->transactions as $t)
                            <tr class="border-t transition-colors hover:bg-gray-800/10" style="border-color:var(--border-color)">
                                <td class="p-4" style="color:var(--text-color)">
                                    {{ $t->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $t->type == 'masuk' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400' }}">
                                        <i class="fas {{ $t->type == 'masuk' ? 'fa-arrow-down' : 'fa-arrow-up' }} mr-1"></i>
                                        {{ ucfirst($t->type) }}
                                    </span>
                                </td>
                                <td class="p-4" style="color:var(--text-color)">
                                    {{ $t->quantity }}
                                </td>
                                <td class="p-4" style="color:var(--text-color)">
                                    {{ $t->user->name ?? 'System' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="p-4 rounded-xl text-center" style="background:var(--panel-color);">
                    <p class="text-sm mb-2" style="color:var(--text-muted)">Total Masuk</p>
                    <p class="text-2xl font-bold" style="color:var(--success-color)">
                        {{ $product->transactions->where('type', 'masuk')->sum('quantity') }}
                    </p>
                </div>
                
                <div class="p-4 rounded-xl text-center" style="background:var(--panel-color);">
                    <p class="text-sm mb-2" style="color:var(--text-muted)">Total Keluar</p>
                    <p class="text-2xl font-bold" style="color:var(--danger-color)">
                        {{ $product->transactions->where('type', 'keluar')->sum('quantity') }}
                    </p>
                </div>
                
                <div class="p-4 rounded-xl text-center" style="background:var(--panel-color);">
                    <p class="text-sm mb-2" style="color:var(--text-muted)">Jumlah Transaksi</p>
                    <p class="text-2xl font-bold" style="color:var(--primary-color)">
                        {{ $product->transactions->count() }}
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animations to table rows
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 100 + (index * 50));
    });
});
</script>
@endsection