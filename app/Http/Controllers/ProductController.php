<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\ActivityLog;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // wajib login
    }

    // tampilkan semua produk
    public function index()
    {
        $products = Product::with(['category','supplier'])->paginate(10); 
        return view('products.index', compact('products' ));
    }

    // form tambah produk
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    // simpan produk baru
    public function store(Request $request)
    {
        // validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        // buat produk baru
        $product = Product::create($request->only('name', 'category_id', 'stock', 'supplier_id', 'price'));

        $userId = auth()->id() ?? 1; // admin default jika belum login

        // catat transaksi masuk otomatis jika stok > 0
        if ($product->stock > 0) {
            StockTransaction::create([
                'product_id' => $product->id,
                'quantity' => $product->stock,
                'type' => 'masuk',
                'user_id' => $userId,
            ]);

            // catat aktivitas pengguna
            ActivityLog::create([
                'user_id' => $userId,
                'action' => 'Produk masuk otomatis',
                'details' => 'Produk: ' . $product->name . ', Jumlah: ' . $product->stock,
            ]);
        }

        // catat aktivitas menambah produk
        ActivityLog::create([
            'user_id' => $userId,
            'action' => 'Menambah produk baru',
            'details' => 'Produk: ' . $product->name,
        ]);

        return redirect()->route('products.index')->with('success', 'Product berhasil ditambahkan.');
    }

    // update produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'required',
            'category_id'=>'required|exists:categories,id',
            'supplier_id'=>'required|exists:suppliers,id',
            'price'=>'required|numeric',
            'stock'=>'required|integer'
        ]);

        $oldStock = $product->stock; // stok lama sebelum update
        $newStock = $request->stock;

        $product->update($request->only('name', 'category_id', 'price', 'stock', 'supplier_id'));

        $userId = auth()->id() ?? 1;

        // cek perubahan stok
        if ($newStock > $oldStock) {
            $added = $newStock - $oldStock;

            StockTransaction::create([
                'product_id' => $product->id,
                'quantity' => $added,
                'type' => 'masuk',
                'user_id' => $userId,
            ]);

            ActivityLog::create([
                'user_id' => $userId,
                'action' => 'Stok bertambah',
                'details' => 'Produk: ' . $product->name . ', Tambah: ' . $added,
            ]);
        } elseif ($newStock < $oldStock) {
            $reduced = $oldStock - $newStock;

            StockTransaction::create([
                'product_id' => $product->id,
                'quantity' => $reduced,
                'type' => 'keluar',
                'user_id' => $userId,
            ]);

            ActivityLog::create([
                'user_id' => $userId,
                'action' => 'Stok berkurang',
                'details' => 'Produk: ' . $product->name . ', Kurang: ' . $reduced,
            ]);
        }

        // catat aktivitas update produk
        ActivityLog::create([
            'user_id' => $userId,
            'action' => 'Update produk',
            'details' => 'Produk: ' . $product->name,
        ]);

        return redirect()->route('products.index')->with('success','Produk berhasil diupdate');
    }

    // form edit produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all(); // FIX: supaya tidak undefined
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    // hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Produk berhasil dihapus');
    }

    // barang keluar (kurangi stok)
    public function keluar(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $quantity = $request->quantity;
        $userId = auth()->id() ?? 1; // admin default jika belum login

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak cukup!');
        }

        // kurangi stok produk
        $product->stock -= $quantity;
        $product->save();

        // catat transaksi keluar
        StockTransaction::create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'type' => 'keluar',
            'user_id' => $userId,
        ]);

        ActivityLog::create([
            'user_id' => $userId,
            'action' => 'Barang keluar',
            'details' => 'Produk: ' . $product->name . ', Jumlah: ' . $quantity,
        ]);

        return redirect()->back()->with('success', 'Transaksi keluar berhasil dicatat.');
    }

public function show(Product $product)
{
    // ambil data lengkap + relasi
    $product->load(['category', 'supplier', 'transactions.user']);

    return view('products.show', compact('product'));
}

public function stockIn(Request $request, Product $product)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $product->increment('stock', $request->quantity);

    // catat transaksi masuk
    StockTransaction::create([
        'product_id' => $product->id,
        'quantity'   => $request->quantity,
        'type'       => 'masuk',
        'user_id'    => auth()->id() ?? 1,
    ]);

    return redirect()->route('products.show', $product->id)
        ->with('success', 'Stok berhasil ditambahkan.');
}

public function stockOut(Request $request, Product $product)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    if ($product->stock < $request->quantity) {
        return redirect()->back()->with('error', 'Stok tidak cukup!');
    }

    $product->decrement('stock', $request->quantity);

    // catat transaksi keluar
    StockTransaction::create([
        'product_id' => $product->id,
        'quantity'   => $request->quantity,
        'type'       => 'keluar',
        'user_id'    => auth()->id() ?? 1,
    ]);

    return redirect()->route('products.show', $product->id)
        ->with('success', 'Stok berhasil dikurangi.');
}
}