@extends('layouts.app')
@section('title', 'Trang chủ khách thuê')
@section('content')
<div class="container mx-auto p-6">
  <h1 class="text-2xl font-bold mb-4">Xin chào khách thuê!</h1>

  <div class="grid md:grid-cols-3 gap-4">
    <div class="p-4 border rounded-xl">
      <h2 class="font-semibold text-gray-600">Phòng đang thuê</h2>
      <p>{{ $phong->so_phong ?? 'Chưa có' }}</p>
    </div>
    <div class="p-4 border rounded-xl">
      <h2 class="font-semibold text-gray-600">Tổng hóa đơn</h2>
      <p>{{ $tong_hoa_don }}</p>
    </div>
    <div class="p-4 border rounded-xl">
      <h2 class="font-semibold text-gray-600">Chưa thanh toán</h2>
      <p>{{ $chua_tt }}</p>
    </div>
  </div>

  <div class="mt-6">
    <a href="{{ route('khach-thue.invoices') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Xem hóa đơn</a>
    <a href="{{ route('khach-thue.profile') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Hồ sơ cá nhân</a>
  </div>
</div>
@endsection
