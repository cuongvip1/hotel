@extends('layouts.app')

@section('title', 'Tạo bài đăng')

@section('content')
    @if(session('ok') || session('error'))
        <div class="max-w-4xl mx-auto mb-6">
            <div
                class="px-4 py-3 rounded-xl shadow-sm font-medium 
                                                {{ session('ok') ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                {!! session('ok') ?? session('error') !!}
            </div>
        </div>
    @endif

    <div class="max-w-3xl mx-auto py-8 px-6">
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 text-white shadow-lg">
                    <i class="ri-add-circle-line"></i>
                </span>
                Tạo bài đăng mới
            </h1>
            <p class="text-sm text-gray-500 mt-1">Sau khi lưu, bạn có thể tải ảnh trong mục “Sửa/Ảnh”.</p>
        </div>

        <form action="{{ route('chu-tro.bai-dang.store') }}" method="POST"
            class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm ring-1 ring-gray-900/5"
            enctype="multipart/form-data">
            @csrf

            {{-- 🏠 Chọn phòng --}}
            <div>
                <label class="block text-sm text-gray-500 mb-1">Chọn phòng</label>
                <select name="phong_id" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                    <option value="">— Chọn phòng —</option>
                    @foreach (($phong ?? []) as $p)
                        <option value="{{ $p['id'] }}" @if(($p['trang_thai'] ?? '') === 'da_thue') disabled @endif>
                            {{ $p['display'] ?? ($p['ten_day_tro'] . ' - ' . $p['so_phong'] . ' (' . number_format($p['gia']) . 'đ)') }}
                        </option>
                    @endforeach
                </select>
                @error('phong_id')
                    <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 📝 Tiêu đề --}}
            <div>
                <label class="block text-sm text-gray-500 mb-1">Tiêu đề</label>
                <input type="text" name="tieu_de" value="{{ old('tieu_de') }}" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                @error('tieu_de') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 📄 Mô tả --}}
            <div>
                <label class="block text-sm text-gray-500 mb-1">Mô tả</label>
                <textarea name="mo_ta" rows="5" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">{{ old('mo_ta') }}</textarea>
                @error('mo_ta') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 💰 Giá niêm yết --}}
            <div>
                <label class="block text-sm text-gray-500 mb-1">Giá niêm yết (đ)</label>
                <input type="number" name="gia_niem_yet" min="0" value="{{ old('gia_niem_yet') }}" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                @error('gia_niem_yet') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 🟢 Trạng thái bài đăng --}}
            <div>
                <label class="block text-sm text-gray-500 mb-1">Trạng thái</label>
                <select name="trang_thai" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                    <option value="dang" selected>Đăng ngay</option>
                    <option value="nhap">Lưu nháp</option>
                    <option value="an">Ẩn (không công khai)</option>
                </select>
                @error('trang_thai')
                    <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 🖼️ Ảnh minh họa --}}
            <div x-data="{files: []}">
                <label class="block text-sm text-gray-500 mb-1">Ảnh minh hoạ (tùy chọn – sẽ upload sau khi tạo)</label>
                <input type="file" name="anh[]" multiple @change="files = [...$event.target.files];"
                    class="block w-full text-sm">
                <div class="mt-3 grid grid-cols-3 gap-3" x-show="files.length">
                    <template x-for="f in files" :key="f.name">
                        <div class="aspect-[4/3] bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                            <img :src="URL.createObjectURL(f)" class="w-full h-full object-cover">
                        </div>
                    </template>
                </div>
                <p class="text-xs text-gray-500 mt-1">* Ảnh trong mục này chỉ để xem trước, chưa gửi lên server.</p>
            </div>

            {{-- 🔘 Nút hành động --}}
            <div class="pt-2">
                <button class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Lưu bài đăng</button>
                <a href="{{ route('chu-tro.bai-dang.index') }}"
                    class="ml-2 px-5 py-2.5 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                    Huỷ
                </a>
            </div>
        </form>
    </div>
@endsection