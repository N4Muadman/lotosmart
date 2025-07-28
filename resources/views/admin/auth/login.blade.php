<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập trang quản trị</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            background: #eaf0e6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            display: flex;
            width: 850px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .form-section {
            flex: 1;
            padding: 40px;
            background-color: #fcf7ef;
        }

        .form-section h2 {
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: 600;
        }

        .form-section p {
            font-size: 14px;
            color: #555;
            margin-bottom: 30px;
        }

        .form-section label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .form-section input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 25px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        .form-section .forgot {
            font-size: 12px;
            color: #7a8652;
            margin-bottom: 20px;
            display: inline-block;
            text-decoration: none;
        }

        .form-section .login-btn {
            width: 100%;
            padding: 14px;
            background-color: #111;
            color: #fff;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
        }

        .form-section .signup {
            margin-top: 15px;
            font-size: 13px;
        }

        .form-section .signup a {
            color: #7a8652;
            text-decoration: none;
        }

        .image-section {
            flex: 1;
            background: url('/assets/img/background-image.png') center center / cover no-repeat;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #ddd;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
        }

        span {
            color: red
        }
        .mb-3{
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-section">
            <h2>Đăng Nhập Trang Quản Trị</h2>
            <form action="{{ route('admin.login') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email">Email<span>*</span></label>
                    <input type="email" style="@error('email') border-color: red @enderror" name="email"
                        placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                        <p style="color: red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password">Mật Khẩu<span>*</span></label>
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                    @error('password')
                        <p style="color: red">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="login-btn">Đăng Nhập</button>
            </form>
        </div>
        <div class="image-section">
            <div class="close-btn">×</div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif
</body>

</html>
