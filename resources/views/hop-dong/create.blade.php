@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm Hợp đồng mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('hop-dong.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ma_nv">Nhân viên:</label>
            <select name="ma_nv" id="ma_nv" class="form-control">
                @foreach ($nhanSu as $nhan)
                    <option value="{{ $nhan->ma_nv }}">{{ $nhan->ho_ten }} ({{ $nhan->ma_nv }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="loai_hop_dong">Loại Hợp đồng:</label>
            <select name="loai_hop_dong" id="loai_hop_dong" class="form-control">
                <option value="1">Hợp đồng có thời hạn</option>
                <option value="2">Hợp đồng không thời hạn</option>
            </select>
        </div>
        <div class="form-group">
            <label for="luong">Lương:</label>
            <input type="number" name="luong" id="luong" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="ngay_bat_dau">Ngày Bắt đầu:</label>
            <input type="text" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control datepicker" required>
        </div>
        <div class="form-group">
            <label for="ngay_ket_thuc">Ngày Kết thúc (Chỉ cho HĐ có thời hạn):</label>
            <input type="text" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control datepicker">
        </div>
        <div class="form-group">
            <label for="ngay_ky">Ngày Ký:</label>
            <input type="text" name="ngay_ky" id="ngay_ky" class="form-control datepicker" required>
        </div>
        <div class="form-group">
            <label for="so_lan_ky">Số lần Ký:</label>
            <input type="number" name="so_lan_ky" id="so_lan_ky" class="form-control" value="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Hợp đồng</button>
        <a href="{{ route('hop-dong.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy"
        });

        $('#loai_hop_dong').change(function() {
            if ($(this).val() == '2') { // '2' is for Hợp đồng không thời hạn
                $('#ngay_ket_thuc').val('');
                $('#ngay_ket_thuc').prop('disabled', true);
                $('#ngay_ket_thuc').css('cursor', 'no-drop');
            } else {
                $('#ngay_ket_thuc').prop('disabled', false);
                $('#ngay_ket_thuc').css('cursor', 'auto');
            }
        });

        // Initial check on page load
        $('#loai_hop_dong').trigger('change');
    });
</script>
@endpush