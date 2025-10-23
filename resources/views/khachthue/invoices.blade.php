@extends('layouts.app')
@section('title', 'Danh sách hóa đơn')
@section('content')
<div class="container mx-auto p-6">
  <h1 class="text-2xl font-bold mb-4">Danh sách hóa đơn</h1>
  <table class="min-w-full border text-sm">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-2 text-left">Mã</th>
        <th class="p-2 text-left">Tháng</th>
        <th class="p-2 text-right">Tổng tiền</th>
        <th class="p-2 text-left">Trạng thái</th>
        <th class="p-2 text-center">Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @foreach($invoices as $i)
      <tr class="border-t hover:bg-gray-50">
        <td class="p-2">{{ $i->id }}</td>
        <td class="p-2">{{ $i->thang }}</td>
        <td class="p-2 text-right">{{ number_format($i->tong_tien) }} đ</td>
        <td class="p-2">{{ $i->trang_thai }}</td>
        <td class="p-2 text-center">
          <a href="{{ route('khach-thue.payments.show', $i->id) }}" class="text-indigo-600 hover:underline">Xem chi tiết</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $invoices->links() }}</div>
</div>
@endsection
