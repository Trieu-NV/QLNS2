<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">


    <title>Đăng Nhập</title>

</head>

<body>
    <div class="login-wrapper container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="login-box">
            <h1 class="text-center h1">Đăng Nhập</h1>
            
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
            
            <form action="{{route('login.post')}}" method="POST" class="login-form">
                @csrf
                <div class="login-acc login-info">
                    <label for="username">Tài Khoản</label>
                    <input type="text" value="{{ old('username', 'admin') }}" name="username" id="username" placeholder="Nhập tài khoản" required>
                </div>
                <div class="login-pass login-info">
                    <label for="password">Mật Khẩu</label>
                    <input type="password" value="{{ old('password', '123456') }}" name="password" id="password" placeholder="Nhập mật khẩu" required>
                </div>
                <div class="show-password">
                    <input type="checkbox" id="showPassword">
                    <label for="showPassword">Hiển thị mật khẩu</label>
                </div>
                <button type="submit" class="login-btn">Đăng Nhập</button>
                
                <a class="link" href="">Quên Mật Khẩu</a>
            </form>
        </div>

    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#showPassword').change(function() {
            if ($(this).is(':checked')) {
                $('#password').attr('type', 'text');
            } else {
                $('#password').attr('type', 'password');
            }
        });
    });
</script>
</html>