@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Xem Chi Tiết Tài Khoản</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('taikhoan.index') }}"> Quay lại</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Tài Khoản:</strong>
                {{ $taikhoan->taikhoan }}
            </div>
        </div>
        {{-- Do not display password directly --}}
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Loại TK:</strong>
                {{ $taikhoan->loaitk }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>SĐT:</strong>
                {{ $taikhoan->sdt ?? 'N/A' }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $taikhoan->email ?? 'N/A' }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Info:</strong>
                {{ $taikhoan->info ?? 'N/A' }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Ngày tạo:</strong>
                {{ $taikhoan->created_at->format('d/m/Y H:i:s') }}
            </div>
        </div>
         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Ngày cập nhật:</strong>
                {{ $taikhoan->updated_at->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>
</div>
@endsection