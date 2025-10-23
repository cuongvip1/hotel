@extends('layouts.app')

@section('title', 'Chỉnh sửa bài đăng')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-6">

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 text-white shadow-lg">
                    <i class="ri-edit-2-line"></i>
                </span>
                Chỉnh sửa: {{ $post['tieu_de'] ?? ('#' . $post['id']) }}
            </h1>
            <a href="{{ route('chu-tro.bai-dang.index') }}"
                class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                Quay lại
            </a>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            {{-- Form cập nhật --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 p-6">
                @if (Route::has('chu-tro.bai-dang.update'))
                    <form method="POST" action="{{ route('chu-tro.bai-dang.update', $post['id']) }}" class="space-y-5">
                        @csrf @method('PUT')

                        <div>
                            <label class="block text-sm text-gray-500 mb-1">Tiêu đề</label>
                            <input type="text" name="tieu_de" value="{{ old('tieu_de', $post['tieu_de'] ?? '') }}" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-500 mb-1">Mô tả</label>
                            <textarea name="mo_ta" rows="6" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">{{ old('mo_ta', $post['mo_ta'] ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-500 mb-1">Giá niêm yết (đ)</label>
                            <input type="number" name="gia_niem_yet" min="0"
                                value="{{ old('gia_niem_yet', $post['gia_niem_yet'] ?? 0) }}" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-500 mb-1">Trạng thái</label>
                            @php $st = old('trang_thai', $post['trang_thai'] ?? 'dang'); @endphp
                            <select name="trang_thai"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                                @foreach (['dang' => 'Đang đăng', 'cho_duyet' => 'Chờ duyệt', 'duyet' => 'Đã duyệt', 'an' => 'Ẩn'] as $k => $v)
                                    <option value="{{ $k }}" @selected($st === $k)>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-2">
                            <button class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Lưu thay
                                đổi</button>
                        </div>
                    </form>
                @else
                    <p class="text-amber-600">Chưa khai báo route <code>chu-tro.bai-dang.update</code>. Vui lòng thêm route để
                        lưu chỉnh sửa.</p>
                @endif
            </div>

            {{-- Ảnh & upload --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 p-6">
                <h2 class="text-lg font-semibold mb-3 flex items-center gap-2">
                    <i class="ri-image-add-line text-indigo-500"></i> Ảnh bài đăng
                </h2>

                <form action="{{ route('chu-tro.bai-dang.upload', $post['id']) }}" method="POST"
                    enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <label
                        class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-700 cursor-pointer">
                        <i class="ri-upload-2-line mr-2"></i> Chọn ảnh
                        <input type="file" name="anh[]" class="hidden" multiple onchange="this.form.submit()">
                    </label>
                    <p class="text-xs text-gray-500 mt-2">Có thể chọn nhiều ảnh. Dung lượng tối đa 5MB/ảnh.</p>
                </form>

                <div class="grid grid-cols-3 gap-3">
                    @forelse(($images ?? []) as $img)
                        <div class="aspect-[4/3] bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                            <img src="{{ $img['url'] ?? $img }}" class="w-full h-full object-cover">
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Chưa có ảnh.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection