@extends('layout')
@section('title', 'Đăng nhập và đăng ký')

@section('content')
    <div class="w-full max-w-md mx-auto pt-6">
        <!-- Logo và tiêu đề -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full mb-4">
                <span class="text-2xl">🎲</span>
            </div>
            <h1 class="text-3xl font-bold mb-2" style="color: var(--text-primary);">630 AI</h1>
            <p style="color: var(--text-disabled);">
                Dự đoán Lô Đề Chuẩn AI
                <br>
                Nâng Tầm Cơ Hội Cùng 630.vn
            </p>
        </div>

        <!-- Form Container -->
        <div class="glass-effect rounded-2xl p-8 shadow-2xl">
            <!-- Tab Navigation -->
            <div class="flex mb-6 rounded-lg p-1" style="background: var(--bg-card);">
                <button id="loginTab" class="flex-1 py-2 px-4 rounded-md font-medium transition-all duration-200"
                    style="background: var(--primary-color); color: white;">
                    Đăng nhập
                </button>
                <button id="registerTab" class="flex-1 py-2 px-4 rounded-md font-medium transition-all duration-200"
                    style="color: var(--text-disabled);">
                    Đăng ký
                </button>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" id="loginForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-2 @error('login.email') text-red-500 @enderror">Email</label>
                    <input type="email" placeholder="Nhập email của bạn" name="login[email]" value="{{old('login.email')}}"
                        class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 transition-all"
                        style="background: var(--bg-card); border: 1px solid var(--border-accent);">
                    @error('login.email')
                        <p class="text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2  @error('login.password') text-red-500 @enderror">Mật
                        khẩu</label>
                    <input type="password" name="login[password]" placeholder="Nhập mật khẩu" value="{{old('login.password')}}"
                        class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 transition-all"
                        style="background: var(--bg-card); border: 1px solid var(--border-accent); ">
                    @error('login.password')
                        <p class="text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm" style="color: var(--text-disabled);">
                        <input type="checkbox" class="mr-2 rounded" name="remember">
                        Ghi nhớ đăng nhập
                    </label>
                    <a href="#" class="text-sm transition-colors"
                        style="color: var(--text-disabled); hover:color: var(--text-primary);">Quên mật khẩu?</a>
                </div>

                <button type="submit"
                    class="w-full py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105"
                    style="background: var(--primary-color); color: white;">
                    Đăng nhập
                </button>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t" style="border-color: var(--border-accent);"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 " style="color: var(--text-disabled); background: var(--bg-primary)">Hoặc</span>
                    </div>
                </div>

                <button onclick="showDemo('google')"
                    class="w-full bg-white text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-all duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    <span>Đăng nhập với Google</span>
                </button>
            </form>

            <!-- Register Form -->
            <form action="" method="POST" id="registerForm" class="space-y-4 hidden">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Họ và tên</label>
                    <input type="text" placeholder="Nhập họ và tên"
                        class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 transition-all"
                        style="background: var(--bg-card); border: 1px solid var(--border-accent); color: var(--text-primary);">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Email</label>
                    <input type="email" placeholder="Nhập email của bạn"
                        class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 transition-all"
                        style="background: var(--bg-card); border: 1px solid var(--border-accent); color: var(--text-primary);">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Số điện thoại</label>
                    <input type="tel" placeholder="Nhập số điện thoại"
                        class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 transition-all"
                        style="background: var(--bg-card); border: 1px solid var(--border-accent); color: var(--text-primary);">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Mật khẩu</label>
                    <input type="password" placeholder="Tạo mật khẩu"
                        class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 transition-all"
                        style="background: var(--bg-card); border: 1px solid var(--border-accent); color: var(--text-primary);">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Xác nhận mật
                        khẩu</label>
                    <input type="password" placeholder="Nhập lại mật khẩu"
                        class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 transition-all"
                        style="background: var(--bg-card); border: 1px solid var(--border-accent); color: var(--text-primary);">
                </div>

                <label class="flex items-start text-sm" style="color: var(--text-disabled);">
                    <input type="checkbox" class="mr-2 mt-1 rounded">
                    <span>Tôi đồng ý với <a href="#" class="underline" style="color: var(--text-primary);">Điều
                            khoản
                            sử dụng</a> và <a href="#" class="underline" style="color: var(--text-primary);">Chính
                            sách bảo mật</a></span>
                </label>

                <button onclick="showDemo('register')"
                    class="w-full py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105"
                    style="background: var(--primary-color); color: white;">
                    Tạo tài khoản
                </button>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t" style="border-color: var(--border-accent);"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2"
                            style="color: var(--text-disabled); background: var(--bg-primary)">Hoặc</span>
                    </div>
                </div>

                <button onclick="showDemo('google')"
                    class="w-full bg-white text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-all duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    <span>Đăng ký với Google</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        // Tab switching
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        loginTab.addEventListener('click', () => {
            loginTab.style.background = 'var(--primary-color)';
            loginTab.style.color = 'white';
            registerTab.style.background = 'transparent';
            registerTab.style.color = 'var(--text-disabled)';
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        });

        registerTab.addEventListener('click', () => {
            registerTab.style.background = 'var(--primary-color)';
            registerTab.style.color = 'white';
            loginTab.style.background = 'transparent';
            loginTab.style.color = 'var(--text-disabled)';
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
        });
    </script>
@endsection
