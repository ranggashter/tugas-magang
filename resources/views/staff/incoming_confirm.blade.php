@extends('layouts.app')

@section('content')
<h1>Konfirmasi Barang Masuk</h1>

<p>Produk: <strong>{{ $task->product->name }}</strong></p>
<p>Jumlah: <strong>{{ $task->quantity }}</strong></p>

{{-- <form action="{{ route('staff.incoming.confirm.process', $task->id) }}" method="POST">
    @csrf

    <label>
        <input type="radio" name="status" value="confirmed" required>
        Sesuai (Konfirmasi)
    </label>
    <br>
    <label>
        <input type="radio" name="status" value="issue" required>
        Tidak Sesuai (Catatan)
    </label>
    <br><br>

    <label for="note">Catatan / Revisi (opsional):</label><br>
    <textarea name="note" id="note" rows="4" cols="50">{{ old('note') }}</textarea>
    <br><br>

    <button type="submit">Simpan Konfirmasi</button>
</form> --}}

<form action="{{ route('staff.incoming.confirm.process', $task->id) }}" method="POST">
    @csrf
    <input type="hidden" name="status" value="approved">
    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">
        Sesuai
    </button>
</form>

<form action="{{ route('staff.incoming.confirm.process', $task->id) }}" method="POST" class="mt-2">
    @csrf
    <input type="hidden" name="status" value="rejected">
    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
        Tidak Sesuai
    </button>
</form>
@endsection
