@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold mb-8 text-indigo-600">👤 Hồ sơ cá nhân</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
            {{-- 🔄 Reload trang để avatar trên header cập nhật --}}
            <script>
                setTimeout(() => location.reload(), 600);
            </script>
        @endif

        <form action="{{ route('chu-tro.profile.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
            @csrf

            <div class="flex items-center space-x-6">
                <img src="{{ $profile['anh_dai_dien'] ?? '/images/default-avatar.png' }}"
                    class="w-24 h-24 rounded-full object-cover shadow">
                <div>
                    <label class="block text-gray-600 dark:text-gray-300 font-medium mb-2">Ảnh đại diện</label>
                    <input type="file" name="anh_dai_dien" accept="image/*"
                        class="text-sm border rounded p-2 w-full bg-gray-50 dark:bg-gray-700">
                </div>
            </div>

            <div>
                <label class="block text-gray-600 dark:text-gray-300 mb-1">Họ tên</label>
                <input type="text" name="ho_ten" value="{{ $profile['ho_ten'] ?? '' }}"
                    class="w-full border rounded p-3 bg-gray-50 dark:bg-gray-700">
            </div>

            <div>
                <label class="block text-gray-600 dark:text-gray-300 mb-1">Email</label>
                <input type="email" value="{{ $profile['email'] ?? '' }}" readonly
                    class="w-full border rounded p-3 bg-gray-100 dark:bg-gray-700 text-gray-500">
            </div>

            <div>
                <label class="block text-gray-600 dark:text-gray-300 mb-1">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" value="{{ $profile['so_dien_thoai'] ?? '' }}"
                    class="w-full border rounded p-3 bg-gray-50 dark:bg-gray-700">
            </div>

            <div>
                <label class="block text-gray-600 dark:text-gray-300 mb-1">Vai trò</label>
                <input type="text" value="{{ ucfirst(str_replace('_', ' ', $profile['vai_tro'] ?? '')) }}" readonly
                    class="w-full border rounded p-3 bg-gray-100 dark:bg-gray-700 text-gray-500">
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
                    💾 Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
    @if (session('success'))
        <script>
            const headerImg = document.querySelector('header img[alt="Avatar"]');
            if (headerImg) {
                const url = new URL(headerImg.src, window.location.origin);
                url.searchParams.set('v', Date.now().toString());
                headerImg.src = url.toString();
            }
        </script>
    @endif


@endsection