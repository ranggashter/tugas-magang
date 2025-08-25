@extends('layouts.app')

@section('content')
<h1>Konfirmasi Barang Keluar</h1>

<p>Produk: <strong>{{ $task->product->name }}</strong></p>
<p>Jumlah: <strong>{{ $task->quantity }}</strong></p>

<form action="{{ route('staff.outgoing.confirm.process', $task->id) }}" method="POST">
    @csrf

    <label>
        <input type="radio" name="status" value="confirmed" required>
        Sesuai (Konfirmasi Barang Siap)
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
</form>
@endsection

