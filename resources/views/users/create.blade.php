<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
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
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            max-width: 600px;
        }
        .form-label {
            font-size: 1.125rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-control-custom {
            font-size: 1.1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            width: 100%;
            transition: border-color 0.2s;
        }
        .form-control-custom:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .btn-custom {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
        }
        .error-message {
            color: #dc3545;
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }
        .form-select-icon {
            position: relative;
        }
        .form-select-icon::after {
            content: "\f078";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header-gradient">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-0" style="font-size: 2.1rem;"><i class="fas fa-user-plus me-2"></i>Tambah User</h1>
                    <p class="mb-0 mt-1 opacity-75" style="font-size: 1.1rem;">Tambahkan pengguna baru ke sistem</p>
                </div>
                <a href="{{ route('users.index') }}" class="btn btn-light" style="border-radius: 8px; padding: 0.5rem 1.5rem; font-weight: 600;">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="form-container mx-auto">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label">Nama User</label>
                    <input type="text" name="name" class="form-control-custom" value="{{ old('name') }}" required placeholder="Masukkan nama user">
                    @error('name') <div class="error-message"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control-custom" value="{{ old('email') }}" required placeholder="email@contoh.com">
                    @error('email') <div class="error-message"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control-custom" required placeholder="Masukkan password">
                    @error('password') <div class="error-message"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control-custom" required placeholder="Konfirmasi password">
                </div>

                <div class="mb-4">
                    <label class="form-label">Role</label>
                    <div class="form-select-icon">
                        <select name="role_id" class="form-control-custom">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('role_id') <div class="error-message"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn-custom btn-primary text-white">
                        <i class="fas fa-save me-2"></i>Simpan User
                    </button>
                    <a href="{{ route('users.index') }}" class="btn-custom btn-secondary text-white">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>