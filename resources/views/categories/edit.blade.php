<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1e293b;
        }
        .form-container {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }
        .form-label {
            font-size: 1.125rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-input {
            font-size: 1.1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            width: 100%;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .btn {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .error-container {
            font-size: 1.1rem;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .error-list li {
            margin-bottom: 0.25rem;
            font-size: 1.05rem;
        }
    </style>
</head>
<body class="p-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="page-title mb-8">
            <i class="fas fa-edit mr-3 text-blue-600"></i>Edit Kategori
        </h1>

        @if ($errors->any())
            <div class="error-container bg-red-100 text-red-800 border-l-4 border-red-500 mb-6">
                <strong class="font-bold text-lg"><i class="fas fa-exclamation-circle mr-2"></i>Terjadi Kesalahan:</strong>
                <ul class="error-list mt-2">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-arrow-right mr-2 text-red-600"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name',$category->name) }}" placeholder="Masukkan nama kategori">
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="btn bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn bg-gray-500 text-white hover:bg-gray-600">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>