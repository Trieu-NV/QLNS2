@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chỉnh sửa Hợp đồng</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('hop-dong.update', $hopDong->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ma_nv">Nhân viên:</label>
            <select name="ma_nv" id="ma_nv" class="form-control">
                @foreach ($nhanSu as $nhan)
                    <option value="{{ $nhan->ma_nv }}" {{ $hopDong->ma_nv == $nhan->ma_nv ? 'selected' : '' }}>{{ $nhan->ho_ten }} ({{ $nhan->ma_nv }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="loai_hop_dong">Loại Hợp đồng:</label>
            <select name="loai_hop_dong" id="loai_hop_dong" class="form-control">
                <option value="1" {{ $hopDong->loai_hop_dong == 1 ? 'selected' : '' }}>Hợp đồng có thời hạn</option>
                <option value="2" {{ $hopDong->loai_hop_dong == 2 ? 'selected' : '' }}>Hợp đồng không thời hạn</option>
            </select>
        </div>
        <div class="form-group">
            <label for="luong">Lương:</label>
            <input type="number" name="luong" id="luong" class="form-control" step="0.01" value="{{ old('luong', $hopDong->luong) }}" required>
        </div>
        <div class="form-group">
            <label for="ngay_bat_dau">Ngày Bắt đầu:</label>
            <input type="text" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control datepicker" value="{{ \Carbon\Carbon::parse($hopDong->ngay_bat_dau)->format('d/m/Y') }}" required>
        </div>
        <div class="form-group">
            <label for="ngay_ket_thuc">Ngày Kết thúc (Chỉ cho HĐ có thời hạn):</label>
            <input type="text" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control datepicker" value="{{ $hopDong->ngay_ket_thuc ? \Carbon\Carbon::parse($hopDong->ngay_ket_thuc)->format('d/m/Y') : '' }}">
        </div>
        <div class="form-group">
            <label for="ngay_ky">Ngày Ký:</label>
            <input type="text" name="ngay_ky" id="ngay_ky" class="form-control datepicker" value="{{ \Carbon\Carbon::parse($hopDong->ngay_ky)->format('d/m/Y') }}" required>
        </div>
        <div class="form-group">
            <label for="so_lan_ky">Số lần Ký:</label>
            <input type="number" name="so_lan_ky" id="so_lan_ky" class="form-control" value="{{ old('so_lan_ky', $hopDong->so_lan_ky) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật Hợp đồng</button>
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
            } else {
                $('#ngay_ket_thuc').prop('disabled', false);
            }
        });

        // Initial check on page load
        $('#loai_hop_dong').trigger('change');
    });
</script>
@endpush