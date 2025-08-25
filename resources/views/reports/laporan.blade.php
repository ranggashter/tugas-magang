@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Laporan Admin</h1>

<h2 class="text-xl font-semibold mb-2">Transaksi Stok</h2>
<table class="table-auto w-full bg-white shadow rounded mb-6">
    <thead class="bg-gray-200">
        <tr>
            <th class="border px-4 py-2">Produk</th>
            <th class="border px-4 py-2">Tipe</th>
            <th class="border px-4 py-2">Qty</th>
            <th class="border px-4 py-2">User</th>
            <th class="border px-4 py-2">Catatan</th>
            <th class="border px-4 py-2">Waktu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $t)
        <tr>
            <td class="border px-4 py-2">{{ $t->product->name }}</td>
            <td class="border px-4 py-2">{{ $t->type=='in'?'Masuk':'Keluar' }}</td>
            <td class="border px-4 py-2">{{ $t->quantity }}</td>
            <td class="border px-4 py-2">{{ $t->user->name }}</td>
            <td class="border px-4 py-2">{{ $t->note ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $t->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2 class="text-xl font-semibold mb-2">Stock Opname</h2>
<table class="table-auto w-full bg-white shadow rounded mb-6">
    <thead class="bg-gray-200">
        <tr>
            <th class="border px-4 py-2">Produk</th>
            <th class="border px-4 py-2">Stok Sistem</th>
            <th class="border px-4 py-2">Stok Fisik</th>
            <th class="border px-4 py-2">User</th>
            <th class="border px-4 py-2">Waktu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($opnames as $o)
        <tr>
            <td class="border px-4 py-2">{{ $o->product->name }}</td>
            <td class="border px-4 py-2">{{ $o->stock_system }}</td>
            <td class="border px-4 py-2">{{ $o->stock_physical }}</td>
            <td class="border px-4 py-2">{{ $o->user->name }}</td>
            <td class="border px-4 py-2">{{ $o->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2 class="text-xl font-semibold mb-2">Aktivitas Pengguna</h2>
<table class="table-auto w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="border px-4 py-2">User</th>
            <th class="border px-4 py-2">Aksi</th>
            <th class="border px-4 py-2">Detail</th>
            <th class="border px-4 py-2">Waktu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activities as $a)
        <tr>
            <td class="border px-4 py-2">{{ $a->user->name }}</td>
            <td class="border px-4 py-2">{{ $a->action }}</td>
            <td class="border px-4 py-2">{{ $a->details }}</td>
            <td class="border px-4 py-2">{{ $a->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
