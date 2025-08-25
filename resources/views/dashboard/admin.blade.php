@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight" style="color:var(--text-color)">
            Dashboard Overview
        </h1>
        <p class="text-base opacity-80" style="color:var(--text-color)">
            Selamat datang, {{ Auth::user()->name }} 👋 Berikut ringkasan aktivitas gudang Anda.
        </p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Produk -->
        <div class="stat-card p-6 rounded-2xl shadow-lg transition hover:scale-105"
             style="background:var(--panel-color)">
            <div class="flex items-center">
                <div class="p-4 rounded-xl mr-4 shadow-inner"
                     style="background:color-mix(in srgb, var(--primary-color) 20%, transparent); color:var(--primary-color);">
                    <i class="fas fa-boxes text-2xl"></i>
                </div>
                <div>
                    <p style="color:var(--text-color)" class="text-sm font-medium">Total Produk</p>
                    <p class="text-3xl font-bold" style="color:var(--primary-color)">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>

        <!-- Transaksi Masuk -->
        <div class="stat-card p-6 rounded-2xl shadow-lg transition hover:scale-105"
             style="background:var(--panel-color)">
            <div class="flex items-center">
                <div class="p-4 rounded-xl mr-4 shadow-inner"
                     style="background:color-mix(in srgb, var(--success-color) 20%, transparent); color:var(--success-color);">
                    <i class="fas fa-arrow-down text-2xl"></i>
                </div>
                <div>
                    <p style="color:var(--text-color)" class="text-sm font-medium">Transaksi Masuk</p>
                    <p class="text-3xl font-bold" style="color:var(--success-color)">{{ $transactionsIn }}</p>
                </div>
            </div>
        </div>

        <!-- Transaksi Keluar -->
        <div class="stat-card p-6 rounded-2xl shadow-lg transition hover:scale-105"
             style="background:var(--panel-color)">
            <div class="flex items-center">
                <div class="p-4 rounded-xl mr-4 shadow-inner"
                     style="background:color-mix(in srgb, var(--warning-color) 20%, transparent); color:var(--warning-color);">
                    <i class="fas fa-arrow-up text-2xl"></i>
                </div>
                <div>
                    <p style="color:var(--text-color)" class="text-sm font-medium">Transaksi Keluar</p>
                    <p class="text-3xl font-bold" style="color:var(--warning-color)">{{ $transactionsOut }}</p>
                </div>
            </div>
        </div>

        <!-- Stok Rendah -->
        <div class="stat-card p-6 rounded-2xl shadow-lg transition hover:scale-105"
             style="background:var(--panel-color)">
            <div class="flex items-center">
                <div class="p-4 rounded-xl mr-4 shadow-inner"
                     style="background:color-mix(in srgb, var(--danger-color) 20%, transparent); color:var(--danger-color);">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
                <div>
                    <p style="color:var(--text-color)" class="text-sm font-medium">Stok Rendah</p>
                    <p class="text-3xl font-bold" style="color:var(--danger-color)">{{ $lowStockProducts->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
        <!-- Chart Section -->
        <div class="dashboard-panel p-6 xl:col-span-1 rounded-2xl shadow-lg"
             style="background:var(--panel-color)">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold" style="color:var(--text-color)">Grafik Stok 30 Hari</h2>
                <div class="p-3 rounded-lg shadow-inner" style="background:var(--primary-color); color:white;">
                    <i class="fas fa-chart-area"></i>
                </div>
            </div>
            <div class="h-72">
                <canvas id="stockChart"></canvas>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="dashboard-panel p-6 xl:col-span-1 rounded-2xl shadow-lg"
             style="background:var(--panel-color)">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold" style="color:var(--text-color)">Aktivitas Terbaru</h2>
                <div class="p-3 rounded-lg shadow-inner" style="background:var(--primary-color); color:white;">
                    <i class="fas fa-history"></i>
                </div>
            </div>
            <div class="space-y-4 h-72 overflow-y-auto pr-2">
                @foreach($recentActivities as $activity)
                <div class="activity-item p-4 rounded-lg border border-gray-200 hover:border-[var(--primary-color)] transition"
                     style="background:var(--panel-color)">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium" style="color:var(--text-color)">{{ $activity->user->name ?? 'Admin' }}</p>
                            <p class="text-sm opacity-80" style="color:var(--text-color)">{{ $activity->action }}</p>
                            <p class="text-xs opacity-70" style="color:var(--text-color)">{{ $activity->details }}</p>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap">{{ $activity->created_at->format('d M H:i') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-panel p-6 xl:col-span-1 rounded-2xl shadow-lg"
             style="background:var(--panel-color)">
            <h2 class="text-lg font-semibold mb-6 flex items-center" style="color:var(--text-color)">
                <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                Aksi Cepat
            </h2>
            <div class="grid grid-cols-2 gap-4 h-72 overflow-y-auto">
                @php
                    $actions = [
                        ['route'=>'products.index','icon'=>'fa-box','label'=>'Kelola Produk'],
                        ['route'=>'categories.index','icon'=>'fa-tags','label'=>'Kelola Kategori'],
                        ['route'=>'suppliers.index','icon'=>'fa-truck-loading','label'=>'Kelola Supplier'],
                        ['route'=>'reports.stock','icon'=>'fa-chart-pie','label'=>'Laporan Stok'],
                        ['route'=>'reports.activity','icon'=>'fa-chart-line','label'=>'Laporan Aktivitas'],
                        ['route'=>'reports.transactions','icon'=>'fa-exchange-alt','label'=>'Laporan Transaksi'],
                    ];
                @endphp

                @foreach($actions as $act)
                <a href="{{ route($act['route']) }}" 
                   class="quick-action p-4 rounded-xl text-center group transition transform hover:-translate-y-1 hover:shadow-lg"
                   style="background:var(--panel-color)">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:opacity-80 shadow-inner"
                         style="background:var(--primary-color); color:white;">
                        <i class="fas {{ $act['icon'] }} text-xl"></i>
                    </div>
                    <p class="text-sm font-medium" style="color:var(--text-color)">{{ $act['label'] }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('stockChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($days),
            datasets: [
                {
                    label: 'Barang Masuk',
                    data: @json($inData),
                    borderColor: getComputedStyle(document.documentElement).getPropertyValue('--success-color').trim(),
                    backgroundColor: 'rgba(22,163,74,0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Barang Keluar',
                    data: @json($outData),
                    borderColor: getComputedStyle(document.documentElement).getPropertyValue('--warning-color').trim(),
                    backgroundColor: 'rgba(251,146,60,0.2)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });
});
</script>
@endsection
