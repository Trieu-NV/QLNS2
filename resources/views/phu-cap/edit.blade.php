@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chỉnh Sửa Phụ Cấp</h1>
    <form action="{{ route('phu-cap.update', $phuCap->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="phu_cap_name">Tên Phụ Cấp:</label>
            <input type="text" class="form-control" id="phu_cap_name" name="phu_cap_name" value="{{ old('phu_cap_name', $phuCap->phu_cap_name) }}" required>
            @error('phu_cap_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="so-tien">Số Tiền:</label>
            <input type="number" class="form-control" id="so-tien" name="so-tien" value="{{ old('so-tien', $phuCap['so-tien']) }}" required min="0">
            @error('so-tien')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="mo-ta">Mô Tả:</label>
            <textarea class="form-control" id="mo-ta" name="mo-ta">{{ old('mo-ta', $phuCap['mo-ta']) }}</textarea>
            @error('mo-ta')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('phu-cap.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection