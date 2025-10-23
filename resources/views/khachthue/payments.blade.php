@extends('layouts.app')
@section('title', 'Chi tiết hóa đơn')
@section('content')
<div class="container mx-auto p-6 max-w-2xl">
  <h1 class="text-2xl font-bold mb-4">Chi tiết hóa đơn #{{ $invoice->id }}</h1>

  <div class="border rounded-xl p-4 mb-4 bg-white">
    <p><strong>Tháng:</strong> {{ $invoice->thang }}</p>
    <p><strong>Tiền phòng:</strong> {{ number_format($invoice->tien_phong) }} đ</p>
    <p><strong>Tiền dịch vụ:</strong> {{ number_format($invoice->tien_dich_vu) }} đ</p>
    <p><strong>Tiền đồng hồ:</strong> {{ number_format($invoice->tien_dong_ho) }} đ</p>
    <p><strong>Tổng cộng:</strong> <span class="text-indigo-600 font-bold">{{ number_format($invoice->tong_tien) }} đ</span></p>
    <p><strong>Trạng thái:</strong> {{ $invoice->trang_thai }}</p>
  </div>

  @if($invoice->trang_thai !== 'da_thanh_toan')
  <form method="POST" action="{{ route('khach-thue.payments.pay', $invoice->id) }}">
    @csrf
    <button class="bg-indigo-600 text-white rounded p-3 hover:bg-indigo-700 w-full">Thanh toán ngay</button>
  </form>
  @else
  <div class="text-green-600 font-semibold">✅ Hóa đơn đã thanh toán</div>
  @endif
</div>
@endsection
