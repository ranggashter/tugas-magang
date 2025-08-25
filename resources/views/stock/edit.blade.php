@extends('layouts.app')

@section('title', 'Edit Transaksi Stok')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Transaksi Stok</h1>

    <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="product_id" class="block font-semibold">Produk</label>
            <select name="product_id" id="product_id" class="border rounded p-2 w-full">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $stock->product_id == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="quantity" class="block font-semibold">Jumlah</label>
            <input type="number" name="quantity" id="quantity" value="{{ $stock->quantity }}"
                   class="border rounded p-2 w-full">
        </div>

        <div class="mb-4">
            <label for="type" class="block font-semibold">Tipe</label>
            <select name="type" id="type" class="border rounded p-2 w-full">
                <option value="masuk" {{ $stock->type == 'masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="keluar" {{ $stock->type == 'keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
