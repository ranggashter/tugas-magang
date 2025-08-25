<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Stockify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        .form-container {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }
        .form-input {
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
        }
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .form-input:hover {
            border-color: #cbd5e1;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-2px);
        }
        .alert-error {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-left: 4px solid #ef4444;
        }
    </style>
</head>
<body class="text-gray-800">
    <div class="min-h-screen flex items-center justify-center py-8 px-4">
        <div class="w-full max-w-2xl">
            <!-- Header -->
            <div class="mb-6 text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Produk</h1>
                <p class="text-gray-600">Perbarui informasi produk yang sudah ada</p>
            </div>

            <!-- Form Container -->
            <div class="form-container p-6 md:p-8">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Produk -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag text-blue-500 mr-1"></i>Nama Produk
                        </label>
                        <input type="text" name="name" id="name"
                            class="form-input px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('name', $product->name) }}" 
                            placeholder="Masukkan nama produk" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori dan Supplier Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Kategori -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-layer-group text-blue-500 mr-1"></i>Kategori
                            </label>
                            <select name="category_id" id="category_id" 
                                class="form-input px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" 
                                        {{ $c->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Supplier -->
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-truck-loading text-blue-500 mr-1"></i>Supplier
                            </label>
                            <select name="supplier_id" id="supplier_id" 
                                class="form-input px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}" 
                                        {{ $s->id == old('supplier_id', $product->supplier_id) ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stok dan Harga Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Stok -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-boxes text-blue-500 mr-1"></i>Stok
                            </label>
                            <input type="number" name="stock" id="stock"
                                class="form-input px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('stock', $product->stock) }}" 
                                min="0" placeholder="Jumlah stok" required>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag text-blue-500 mr-1"></i>Harga (Rp)
                            </label>
                            <input type="number" name="price" id="price"
                                class="form-input px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('price', $product->price) }}" 
                                min="0" step="0.01" placeholder="Harga produk" required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex flex-col sm:flex-row gap-3 mt-8">
                        <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center sm:flex-1">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('products.index') }}" class="btn-secondary text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center sm:flex-1">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Info -->
            <div class="mt-6 text-center text-sm text-gray-500">
                <p><i class="fas fa-info-circle mr-1"></i>Pastikan semua data terisi dengan benar sebelum menyimpan</p>
            </div>
        </div>
    </div>
</body>
</html>