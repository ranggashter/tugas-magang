<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-gradient {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 15px 15px;
        }
        .product-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .table thead th {
            background-color: #f1f5fd;
            border-top: none;
            font-weight: 600;
            padding: 1rem 0.75rem;
            font-size: 1.05rem; /* Diperbesar sedikit */
        }
        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            font-size: 1.05rem; /* Diperbesar sedikit */
        }
        .table-hover tbody tr:hover {
            background-color: rgba(37, 117, 252, 0.05);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
        .badge {
            padding: 0.5em 0.75em;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.95rem; /* Diperbesar sedikit */
        }
        .btn-action {
            padding: 0.5rem 0.85rem; /* Diperbesar sedikit */
            font-size: 0.95rem; /* Diperbesar sedikit */
            border-radius: 6px;
            margin: 0 3px; /* Diperbesar jaraknya */
            white-space: nowrap;
        }
        .action-container {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
        }
        .btn-add {
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(37, 117, 252, 0.3);
            font-size: 1.05rem; /* Diperbesar sedikit */
        }
        .footer {
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 2rem;
            color: #6c757d;
            font-size: 1rem; /* Diperbesar sedikit */
        }
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }
        .empty-state h5 {
            font-size: 1.4rem; /* Diperbesar sedikit */
        }
        .empty-state p {
            font-size: 1.1rem; /* Diperbesar sedikit */
        }
        .product-name {
            font-size: 1.1rem; /* Diperbesar sedikit */
        }
        @media (max-width: 992px) {
            .action-container {
                flex-wrap: wrap;
                gap: 0.4rem;
            }
            .btn-action {
                margin: 0;
                flex: 1;
                min-width: 80px;
            }
        }
        @media (max-width: 768px) {
            .action-container {
                flex-direction: row;
                justify-content: flex-start;
            }
            .btn-action {
                padding: 0.45rem 0.7rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="header-gradient">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-0" style="font-size: 2.1rem;"><i class="fas fa-boxes me-2"></i>Manajemen Produk</h1>
                    <p class="mb-0 mt-1 opacity-75" style="font-size: 1.1rem;">Daftar lengkap produk yang tersedia di sistem</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-light btn-add">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Produk
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="product-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Supplier</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th width="300" class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td class="ps-4 fw-semibold text-muted">#{{ $product->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-2 me-2">
                                            <i class="fas fa-box text-primary"></i>
                                        </div>
                                        <div class="fw-semibold product-name">{{ $product->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $product->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td>{{ $product->supplier->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                        {{ $product->stock }} {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </td>
                                <td class="fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="pe-4">
                                    <div class="action-container">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-action text-white">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-action text-white">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-action" onclick="return confirm('Yakin hapus produk ini?')">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if(count($products) == 0)
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5 class="mt-2">Belum ada produk</h5>
                                        <p>Silakan tambahkan produk pertama Anda</p>
                                        <a href="{{ route('products.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-1"></i>Tambah Produk
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>© 2023 Sistem Manajemen Produk</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>