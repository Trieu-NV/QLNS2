@extends('layouts.app')

@section('content')
<div class="container mx-auto sm:px-8" style="max-width:unset">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Bảng Chuyên Cần</h2>
        </div>
        <div class="my-2 flex ">
            <form method="GET" action="{{ route('chuyen-can.index') }}" class="d-flex gap-2 mb-1 sm:mb-0">
                <div class="relative">
                    <select name="month" class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == $selectedMonth ? 'selected' : '' }}>Tháng {{ $m }}</option>
                        @endfor
                    </select>
                </div>
                <div class="relative">
                    <select name="year" class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                        @for ($y = Carbon\Carbon::now()->year - 5; $y <= Carbon\Carbon::now()->year + 5; $y++)
                            <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>Năm {{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="block relative">
                    <button type="submit"
                        class="h-full w-full flex items-center justify-center bg-blue-500 hover:bg-blue-700  font-bold py-2 px-4 rounded-r sm:rounded-r-md">
                        Lọc
                    </button>
                </div>
            </form>
        </div>
        <div class="-mx-4 sm:-mx-8 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="w-8 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                STT
                            </th>

                            <th class="d-none border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Mã NV
                            </th>
                            <th class=" border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Họ Tên
                            </th>
                            <th class=" border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Phòng Ban
                            </th>
                            <th class=" border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tháng/Năm
                            </th>
                            <th class=" border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Công Chuẩn
                            </th>
                            <th class=" border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Đi Làm
                            </th>
                            <th class=" border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nghỉ
                            </th>
                            <th class=" border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Phép
                            </th>
                            <th class=" border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tiền Thưởng
                            </th>
                            <th class=" border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tiền Phạt
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($chuyenCanData as $data)
                            <tr>
                                <td class="  border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $loop->index + 1 }}</p>
                                </td>

                                <td class="d-none  border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $data['ma_nv'] }}</p>
                                </td>
                                <td class=" border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $data['ho_ten'] }}</p>
                                </td>
                                <td class=" border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $data['ten_phong_ban'] }}</p>
                                </td>
                                <td class=" border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $data['thang_nam'] }}</p>
                                </td>
                                <td class=" border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $data['so_cong_chuan'] }}</p>
                                </td>
                                <td class=" border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $data['so_ngay_di_lam'] }}</p>
                                </td>
                                <td class=" border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $data['so_ngay_nghi'] }}</p>
                                </td>
                                <td class=" border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $data['so_ngay_phep'] }}</p>
                                </td>
                                <td class=" border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ number_format($data['tien_thuong'], 0, ',', '.') }} VNĐ</p>
                                </td>
                                <td class=" border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ number_format($data['tien_phat'], 0, ',', '.') }} VNĐ</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    <p class="text-gray-900 whitespace-no-wrap">Không có dữ liệu chuyên cần.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection