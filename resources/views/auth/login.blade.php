<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stockify</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6a11cb;
            --primary-light: rgba(106, 17, 203, 0.1);
            --text-color: #2d3748;
            --text-muted: #718096;
            --card-bg: #ffffff;
            --panel-color: #f8fafc;
            --border-color: #e2e8f0;
            --success-color: #38a169;
            --warning-color: #d69e2e;
            --danger-color: #e53e3e;
            --info-color: #3182ce;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            color: var(--text-color);
        }

        .modern-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1);
        }

        .btn-primary {
            background: var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #5809b5;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(106, 17, 203, 0.4);
        }

        .error-shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(1deg); }
            66% { transform: translateY(-10px) rotate(-1deg); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-12">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden z-0">
        <!-- Floating geometric shapes -->
        <div class="absolute top-1/4 left-1/4 w-32 h-32 border border-purple-200 rounded-lg rotate-45 floating-element"></div>
        <div class="absolute top-3/4 right-1/4 w-24 h-24 border border-blue-200 rounded-lg rotate-12 floating-element" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/12 w-16 h-16 border border-indigo-200 rounded-lg rotate-45 floating-element" style="animation-delay: 4s;"></div>
    </div>
    
    <div class="w-full max-w-md relative z-10">
        <!-- Header -->
        <div class="text-center mb-8 fade-in">
            <!-- Logo -->
           <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl shadow-lg mb-6">
   @if(setting('logo'))
        <img src="{{ app_logo() }}" alt="Logo" class="w-full h-full object-contain transition-transform duration-300 hover:scale-110">
    @else
        <i class="fas fa-boxes text-3xl text-blue-600 transition-all duration-300 hover:text-blue-700"></i>
    @endif
</div>
            
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                 {{ app_name() ?? 'Stockify' }}
            </h1>
            <p class="text-gray-600">Sistem Manajemen Gudang</p>
            <div class="w-32 h-1 bg-gradient-to-r from-purple-400 to-blue-400 mx-auto mt-4 rounded-full"></div>
        </div>
        
        <!-- Login Form -->
        <div class="modern-card p-8 fade-in hover-lift">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 rounded-lg">
                    <p class="text-green-700 text-sm font-medium">{{ session('status') }}</p>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                @csrf
                
                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope text-purple-500 mr-2"></i>
                        Alamat Email
                    </label>
                    <div class="relative">
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus 
                            autocomplete="email"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none form-input"
                            placeholder="masukkan email anda"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-check-circle text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="text-red-600 text-sm mt-2 flex items-center error-shake">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock text-purple-500 mr-2"></i>
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none form-input"
                            placeholder="masukkan kata sandi"
                        />
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="eye-icon" class="fas fa-eye text-gray-400 hover:text-purple-500 transition-colors"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm mt-2 flex items-center error-shake">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center group cursor-pointer">
                        <div class="relative">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="sr-only"
                            />
                            <div class="w-5 h-5 border-2 border-gray-300 rounded bg-white group-hover:border-purple-400 transition-colors duration-300"></div>
                            <i class="fas fa-check absolute inset-0 text-purple-500 opacity-0 transition-opacity duration-300"></i>
                        </div>
                        <span class="ml-3 text-gray-700 text-sm group-hover:text-purple-600 transition-colors">
                            Ingat saya
                        </span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-purple-600 hover:text-purple-500 text-sm underline-offset-4 hover:underline transition-colors">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>
                
                <!-- Login Button -->
                <button 
                    type="submit" 
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition-all duration-300 relative overflow-hidden group"
                    id="loginBtn"
                >
                    <span class="relative z-10 flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-3"></i>
                        <span id="loginText">Masuk ke Sistem</span>
                    </span>
                </button>
            </form>
            
            <!-- Footer Info -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span>Sistem Online</span>
                    </div>
                    <span>v2.1.0</span>
                </div>
            </div>
        </div>
        
        <!-- Additional Info -->
        <div class="text-center mt-6 text-gray-500 text-sm">
            <p>© {{ date('Y') }} Stockify Management System</p>
            <p class="mt-1">All rights reserved</p>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Password toggle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'fas fa-eye-slash text-gray-400 hover:text-purple-500 transition-colors';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'fas fa-eye text-gray-400 hover:text-purple-500 transition-colors';
            }
        }
        
        // Remember me checkbox
        document.getElementById('remember_me').addEventListener('change', function() {
            const checkbox = this;
            const checkmark = checkbox.nextElementSibling;
            
            if (checkbox.checked) {
                checkmark.style.opacity = '1';
                checkbox.previousElementSibling.style.borderColor = 'var(--primary-color)';
                checkbox.previousElementSibling.style.backgroundColor = 'rgba(106, 17, 203, 0.1)';
            } else {
                checkmark.style.opacity = '0';
                checkbox.previousElementSibling.style.borderColor = '#d1d5db';
                checkbox.previousElementSibling.style.backgroundColor = '#ffffff';
            }
        });
        
        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            const text = document.getElementById('loginText');
            
            btn.disabled = true;
            btn.classList.add('opacity-75');
            text.innerHTML = 'Memproses <i class="fas fa-circle-notch fa-spin ml-2"></i>';
            
            // Add loading effect
            btn.classList.add('cursor-not-allowed');
        });
        
        // Input focus effects
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-purple-200');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-purple-200');
            });
        });
        
        // Initialize effects
        window.addEventListener('load', function() {
            // Add entrance animations
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                el.style.animationDelay = (index * 0.2) + 's';
            });
        });
    </script>
</body>
</html>