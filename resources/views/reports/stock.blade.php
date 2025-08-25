<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 0;
        }
        .header-gradient {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 15px 15px;
        }
        .card-custom {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .card-header-custom {
            background-color: #f1f5fd;
            border-bottom: 1px solid #e3e9f7;
            font-weight: 600;
            font-size: 1.25rem;
            padding: 1.25rem 1.5rem;
        }
        .card-body-custom {
            padding: 1.5rem;
        }
        .table-custom {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .table thead th {
            background-color: #1e40af;
            color: white;
            font-weight: 600;
            padding: 1rem;
            font-size: 1.05rem;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            font-size: 1.05rem;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(37, 117, 252, 0.05);
        }
        .stock-badge {
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .product-name {
            font-weight: 500;
            color: #1f2937;
        }
        .category-badge {
            background-color: #e0e7ff;
            color: #4338ca;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-weight: 500;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }
    </style>
</head>
<body>
    <div class="header-gradient">
        <div class="container">
            <div class="text-center">
                <h1 class="fw-bold mb-0" style="font-size: 2.1rem;"><i class="fas fa-boxes me-2"></i>Laporan Stok Barang</h1>
                <p class="mb-0 mt-1 opacity-75" style="font-size: 1.1rem;">Data stok produk terkini</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card-custom">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <span><i class="fas fa-cubes me-2"></i>Data Stok Produk</span>
                <span class="badge bg-primary">{{ $products->count() }} Produk</span>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-hover table-custom">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <span class="product-name">
                                        <i class="fas fa-box me-2 text-primary"></i>{{ $product->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="category-badge">
                                        <i class="fas fa-tag me-2"></i>{{ $product->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->stock > 20)
                                    <span class="stock-badge bg-success text-white">
                                        <i class="fas fa-check-circle me-2"></i>{{ $product->stock }}
                                    </span>
                                    @elseif($product->stock > 0)
                                    <span class="stock-badge bg-warning text-dark">
                                        <i class="fas fa-exclamation-triangle me-2"></i>{{ $product->stock }}
                                    </span>
                                    @else
                                    <span class="stock-badge bg-danger text-white">
                                        <i class="fas fa-times-circle me-2"></i>{{ $product->stock }}
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($products->count() == 0)
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open"></i>
                                        <h5 class="mt-2">Tidak ada data produk</h5>
                                        <p>Belum ada produk yang terdaftar dalam sistem</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>