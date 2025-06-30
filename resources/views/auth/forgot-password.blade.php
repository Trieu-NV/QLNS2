<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Quên Mật Khẩu</title>
</head>

<body>
    <div class="login-wrapper container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="login-box">
            <h1 class="text-center h1">Quên Mật Khẩu</h1>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('password.email') }}" method="POST" class="login-form">
                @csrf
                <div class="login-acc login-info">
                    <label for="username">Tài Khoản</label>
                    <input type="text" 
                           value="{{ old('username') }}" 
                           name="username" 
                           id="username" 
                           placeholder="Nhập tài khoản" 
                           class="@error('username') is-invalid @enderror"
                           required>
                    @error('username')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="login-pass login-info">
                    <label for="email">Email</label>
                    <input type="email" 
                           value="{{ old('email') }}" 
                           name="email" 
                           id="email" 
                           placeholder="Nhập email đăng ký" 
                           class="@error('email') is-invalid @enderror"
                           required>
                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <button type="submit" class="login-btn">Gửi Link Đặt Lại Mật Khẩu</button>
                
                <div class="text-center mt-3">
                    <a class="link" href="{{ route('login') }}">Quay Lại Đăng Nhập</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 