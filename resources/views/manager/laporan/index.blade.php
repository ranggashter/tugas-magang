@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Laporan Stok</h1>

<form method="GET" class="mb-4 flex gap-2">
    <select name="product_id" class="border p-2 rounded">
        <option value="">Semua Produk</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
        @endforeach
    </select>

    <select name="category_id" class="border p-2 rounded">
        <option value="">Semua Kategori</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>

    <input type="date" name="from" value="{{ request('from') }}" class="border p-2 rounded">
    <input type="date" name="to" value="{{ request('to') }}" class="border p-2 rounded">

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
    {{-- <a href="{{ route('manager.laporan-stok.export', request()->query()) }}" class="bg-green-500 text-white px-4 py-2 rounded ml-2">Export Excel</a> --}}
</form>

<table class="w-full border-collapse border">
    <thead>
        <tr class="bg-gray-200">
            <th class="border px-2 py-1">Tanggal</th>
            <th class="border px-2 py-1">Produk</th>
            <th class="border px-2 py-1">Kategori</th>
            <th class="border px-2 py-1">Tipe</th>
            <th class="border px-2 py-1">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $t)
        <tr>
            <td class="border px-2 py-1">{{ $t->created_at->format('d-m-Y H:i') }}</td>
            <td class="border px-2 py-1">{{ $t->product->name }}</td>
            <td class="border px-2 py-1">{{ $t->product->category->name }}</td>
            <td class="border px-2 py-1">{{ ucfirst($t->type) }}</td>
            <td class="border px-2 py-1">{{ $t->quantity }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="border px-2 py-1 text-center">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
