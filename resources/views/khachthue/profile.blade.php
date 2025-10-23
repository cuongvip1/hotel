@extends('layouts.app')
@section('title', 'Hồ sơ khách thuê')
@section('content')
<div class="container mx-auto p-6 max-w-lg">
  <h1 class="text-2xl font-bold mb-4">Hồ sơ khách thuê</h1>

  <form method="POST" action="{{ route('khach-thue.profile.update') }}" class="grid gap-3">
    @csrf @method('PUT')
    <input type="hidden" name="id" value="{{ $profile->id }}">
    <label>CCCD</label>
    <input name="cccd" class="border rounded p-2" value="{{ $profile->cccd }}">

    <label>Ngân sách tối thiểu</label>
    <input name="ngan_sach_min" class="border rounded p-2" value="{{ $profile->ngan_sach_min }}">

    <label>Ngân sách tối đa</label>
    <input name="ngan_sach_max" class="border rounded p-2" value="{{ $profile->ngan_sach_max }}">

    <button class="bg-blue-600 text-white rounded p-2">Cập nhật</button>
  </form>
</div>
@endsection
