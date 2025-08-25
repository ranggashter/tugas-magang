<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Product;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('product','user')->latest()->get();
        return view('staff.barang-masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $products = Product::all();
        return view('staff.barang-masuk.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $barang = BarangMasuk::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'user_id' => auth()->id(),
        ]);

        // update stock
        $product = Product::find($request->product_id);
        $product->stock += $request->quantity;
        $product->save();

        return redirect()->route('staff.barang-masuk.index')->with('success', 'Barang masuk berhasil ditambahkan.');
    }
}
