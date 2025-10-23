@extends('layouts.app')

@section('title', 'Bài đăng của tôi')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-6">

        {{-- Header --}}
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 text-white shadow-lg">
                    <i class="ri-newspaper-line"></i>
                </span>
                Bài đăng của tôi
            </h1>

            <div class="flex items-center gap-3">
                <a href="{{ route('chu-tro.bai-dang.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    <i class="ri-add-line text-lg"></i> Tạo bài đăng
                </a>
            </div>
        </div>

        {{-- Filter --}}
        <form method="GET" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 p-5 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-500">Từ khoá</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900"
                        placeholder="Tiêu đề, mô tả...">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Trạng thái</label>
                    <select name="trang_thai"
                        class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                        <option value="">Tất cả</option>
                        @foreach (['dang' => 'Đang đăng', 'an' => 'Ẩn', 'nhap' => 'Nháp'] as $k => $v)
                            <option value="{{ $k }}" @selected(request('trang_thai') === $k)>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-500">Giá từ</label>
                    <input type="number" name="price_min" value="{{ request('price_min') }}"
                        class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900" min="0">
                </div>
                <div>
                    <label class="text-sm text-gray-500">Đến</label>
                    <input type="number" name="price_max" value="{{ request('price_max') }}"
                        class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900" min="0">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Sắp xếp</label>
                    <select name="sort"
                        class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                        <option value="">Mặc định</option>
                        <option value="new" @selected(request('sort') === 'new')>Mới nhất</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Giá tăng</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Giá giảm</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex items-center gap-3">
                <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    <i class="ri-filter-2-line mr-1"></i> Lọc
                </button>
                <a href="{{ route('chu-tro.bai-dang.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                    Xoá lọc
                </a>
            </div>
        </form>

        {{-- Grid list --}}
        @php
            $items = $posts instanceof \Illuminate\Contracts\Pagination\Paginator ? $posts->items() : (is_array($posts) ? $posts : []);
        @endphp

        @if (empty($items))
            <div class="rounded-2xl bg-white dark:bg-gray-800 p-10 text-center ring-1 ring-gray-900/5">
                <p class="text-gray-500">Chưa có bài đăng nào.</p>
                <a href="{{ route('chu-tro.bai-dang.create') }}"
                    class="inline-flex mt-4 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    Tạo bài đăng đầu tiên
                </a>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($items as $b)
                    @php
                        $price = number_format($b['gia_niem_yet'] ?? 0);
                        $status = $b['trang_thai'] ?? 'dang';
                        $badge = [
                            'dang' => 'bg-indigo-100 text-indigo-700',
                            'an' => 'bg-gray-100 text-gray-700',
                            'nhap' => 'bg-yellow-100 text-yellow-700',
                        ][$status] ?? 'bg-gray-100 text-gray-700';
                        $img = !empty($b['anh_dai_dien'])
                            ? url($b['anh_dai_dien'])
                            : '/images/no-image.png';
                    @endphp

                    <div
                        class="group rounded-2xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 hover:shadow-lg transition">
                        {{-- Ảnh đại diện --}}
                        <div class="aspect-[16/9] bg-gray-100 overflow-hidden">
                            <img src="{{ $img }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                                alt="Ảnh phòng">
                        </div>

                        {{-- Nội dung --}}
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="font-semibold line-clamp-2 text-lg">{{ $b['tieu_de'] ?? 'Bài đăng' }}</h3>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $status }}</span>
                            </div>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $b['ten_day_tro'] ?? 'Không rõ dãy trọ' }} - Phòng {{ $b['so_phong'] ?? '---' }}
                            </p>

                            <div class="mt-2 text-indigo-600 font-semibold text-lg">{{ $price }} đ/tháng</div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($b['created_at'] ?? now())->format('d/m/Y') }}
                            </div>

                            <div class="mt-4 flex items-center gap-2">
                                <a href="{{ route('room.detail', $b['id']) }}"
                                    class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm">Xem</a>
                                <a href="{{ route('chu-tro.bai-dang.edit', $b['id']) }}"
                                    class="px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 text-sm">Sửa</a>
                                <form method="POST" action="{{ route('chu-tro.bai-dang.destroy', $b['id']) }}"
                                    onsubmit="return confirm('Xoá bài đăng này?')">
                                    @csrf @method('DELETE')
                                    <button
                                        class="px-3 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700 text-sm">Xoá</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($posts instanceof \Illuminate\Pagination\Paginator || $posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-8">{{ $posts->withQueryString()->links() }}</div>
            @endif
        @endif
    </div>
@endsection