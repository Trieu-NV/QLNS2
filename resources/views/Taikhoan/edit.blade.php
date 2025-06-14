@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Sửa Tài Khoản: {{ $taikhoan->taikhoan }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('taikhoan.index') }}"> Quay lại</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Đã có lỗi xảy ra.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('taikhoan.update',$taikhoan->taikhoan) }}" method="POST">
        @csrf
        @method('PUT') {{-- Use PUT method for updates --}}

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tài Khoản:</strong>
                    <input type="text" name="taikhoan_display" class="form-control" value="{{ $taikhoan->taikhoan }}" disabled>
                    {{-- If you want to allow 'taikhoan' (PK) to be edited, it's more complex and generally not recommended.
                         If you must, ensure the name attribute is 'taikhoan' and handle uniqueness carefully in the controller.
                    <input type="hidden" name="taikhoan" value="{{ $taikhoan->taikhoan }}">
                    --}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Mật Khẩu Mới (để trống nếu không đổi):</strong>
                    <input type="password" name="matkhau" class="form-control" placeholder="Mật khẩu mới">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Loại TK (vd: A, U):</strong>
                    <input type="text" name="loaitk" value="{{ $taikhoan->loaitk }}" class="form-control" placeholder="Loại tài khoản" maxlength="1">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>SĐT:</strong>
                    <input type="text" name="sdt" value="{{ $taikhoan->sdt }}" class="form-control" placeholder="Số điện thoại">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" value="{{ $taikhoan->email }}" class="form-control" placeholder="Email">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Info:</strong>
                    <input type="text" name="info" value="{{ $taikhoan->info }}" class="form-control" placeholder="Thông tin thêm">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
              <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </div>
        </div>
    </form>
</div>
@endsection