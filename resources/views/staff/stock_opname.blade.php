@extends('layouts.app')

@section('content')
<h1>Stock Opname</h1>

<form action="{{ route('staff.stock_opname.process') }}" method="POST">
    @csrf
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Stok Sistem</th>
                <th>Stok Fisik (Hitung Manual)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <input type="number" name="stocks[{{ $product->id }}]" value="{{ old('stocks.'.$product->id, $product->stock) }}" min="0">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <button type="submit">Simpan Stock Opname</button>
</form>
@endsection
