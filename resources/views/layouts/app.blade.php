<!DOCTYPE html>
<html lang="vi" class="scroll-smooth" x-data="darkMode()" x-init="init()" :class="{ 'dark': isDark }">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Hệ Thống Trọ')</title>

  {{-- ✅ Tailwind & AlpineJS --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  {{-- ✅ Remix Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

  <style>
    @keyframes gradientFlow {

      0%,
      100% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }
    }

    .animate-gradientFlow {
      animation: gradientFlow 15s ease infinite;
    }

    .reveal {
      opacity: 0;
      transform: translateY(40px);
      transition: all .8s ease;
    }

    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }

    @keyframes fade-in {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in {
      animation: fade-in .4s ease-out;
    }
  </style>
</head>

<body class="antialiased flex flex-col min-h-screen transition-all duration-700
             bg-gradient-to-br from-indigo-50 via-white to-blue-50 
             dark:from-gray-950 dark:via-gray-900 dark:to-gray-950
             bg-[length:200%_200%] animate-gradientFlow 
             text-gray-800 dark:text-gray-100">

  {{-- ⚡ FLASH MESSAGE --}}
  @if (session('ok') || session('success') || session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
      class="fixed top-6 right-6 z-[9999] px-5 py-3 rounded-2xl shadow-xl text-white text-sm font-medium 
                                         animate-fade-in
                                         {{ session('error') ? 'bg-red-600' : 'bg-gradient-to-r from-green-500 to-emerald-600' }}">
      <i class="ri-information-line mr-2"></i>
      {{ session('ok') ?? session('success') ?? session('error') }}
    </div>
  @endif


  {{-- 🌟 NAVBAR --}}
  @unless (Request::is('login') || Request::is('register'))
    <header x-data="{ open: false, isDark: false }"
      class="sticky top-0 z-50 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50 transition-all duration-500"
      :class="{ 'bg-gray-900/80 text-gray-100 shadow-lg': isDark, 'bg-white/80 text-gray-900 shadow-md': !isDark }">
      <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">

        {{-- 🏠 Logo --}}
        <a href="{{ route('home') }}" class="flex items-center space-x-2 font-semibold group">
          <i class="ri-home-5-line text-indigo-600 text-2xl group-hover:scale-110 transition-transform"></i>
          <span :class="{ 'text-white': isDark, 'text-gray-800': !isDark }">Hệ Thống Trọ</span>
        </a>

        {{-- 📋 Menu --}}
        <div class="hidden md:flex items-center space-x-6 font-medium">
          <a href="{{ route('home') }}"
            class="hover:text-indigo-500 {{ Request::is('/') ? 'text-indigo-600 font-semibold' : '' }}">Trang chủ</a>
          <a href="{{ route('listing') }}"
            class="hover:text-indigo-500 {{ Request::is('bai-dang') ? 'text-indigo-600 font-semibold' : '' }}">Danh sách
            trọ</a>
          <a href="/search"
            class="hover:text-indigo-500 {{ Request::is('search') ? 'text-indigo-600 font-semibold' : '' }}">Tìm kiếm</a>
        </div>

        {{-- 👤 User --}}
        <div class="flex items-center space-x-4 relative">
          @if (!session('user'))
            <a href="{{ route('login') }}" class="hover:text-indigo-500">Đăng nhập</a>
            <a href="{{ route('register') }}"
              class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-lg shadow-md hover:shadow-lg hover:scale-[1.03] transition">
              Đăng ký
            </a>
          @else
            @php
              $u = session('user', []);
              $rawAvatar = $u['anh_dai_dien'] ?? '/images/default-avatar.png';
              if (is_array($rawAvatar))
                $rawAvatar = $rawAvatar[0] ?? '/images/default-avatar.png';
              if ($rawAvatar && !str_starts_with($rawAvatar, 'http') && !str_starts_with($rawAvatar, '/')) {
                $rawAvatar = rtrim(env('API_URL'), '/') . '/' . ltrim($rawAvatar, '/');
              }
              $buster = session('avatar_bust') ?? null;
              $avatar = $rawAvatar . ($buster ? ((str_contains($rawAvatar, '?') ? '&' : '?') . 'v=' . $buster) : '');
            @endphp

            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
              <button class="flex items-center space-x-3 hover:opacity-80 transition">
                <span class="hidden sm:inline text-gray-700 dark:text-gray-200 font-medium">
                  Xin chào, <strong>{{ $u['ho_ten'] ?? 'Người dùng' }}</strong>
                </span>
                <img src="{{ $avatar }}"
                  class="w-10 h-10 rounded-full border-2 border-indigo-500 object-cover cursor-pointer" alt="Avatar"
                  onerror="this.src='/images/default-avatar.png';">
                <i class="ri-arrow-down-s-line text-xl text-gray-500"></i>
              </button>

              {{-- Dropdown --}}
              <div x-show="open" x-transition.opacity x-cloak
                class="absolute right-0 mt-3 w-56 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700 z-50">
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                  <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $u['email'] ?? '' }}</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">
                    {{ str_replace('_', ' ', $u['vai_tro'] ?? 'người dùng') }}
                  </p>
                </div>

                <a href="{{ route('chu-tro.profile.show') }}"
                  class="flex items-center px-4 py-3 hover:bg-indigo-50 dark:hover:bg-gray-700 text-sm transition">
                  <i class="ri-user-line mr-2 text-indigo-500"></i> Hồ sơ cá nhân
                </a>

                <a href="{{ route('chu-tro.dashboard') }}"
                  class="flex items-center px-4 py-3 hover:bg-indigo-50 dark:hover:bg-gray-700 text-sm transition">
                  <i class="ri-dashboard-line mr-2 text-indigo-500"></i> Bảng điều khiển
                </a>

                <a href="{{ route('chu-tro.bai-dang.index') }}"
                  class="flex items-center px-4 py-3 text-sm hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                  <i class="ri-file-list-line text-indigo-500 mr-2"></i> Quản lý bài đăng
                </a>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button
                    class="flex items-center w-full px-4 py-3 text-red-500 hover:bg-red-50 dark:hover:bg-gray-700 text-sm transition">
                    <i class="ri-logout-box-line mr-2"></i> Đăng xuất
                  </button>
                </form>
              </div>
            </div>

          @endif

          {{-- 🌙 Dark Mode --}}
          <button @click="toggleDark()" class="ml-1 p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <template x-if="!isDark"><i class="ri-moon-line text-xl text-gray-700"></i></template>
            <template x-if="isDark"><i class="ri-sun-line text-xl text-yellow-400"></i></template>
          </button>
        </div>
      </nav>
    </header>
  @endunless

  <main class="flex-grow transition-all duration-500">@yield('content')</main>

  {{-- FOOTER --}}
  <footer class="relative mt-24 text-gray-200 overflow-hidden reveal">
    <div
      class="absolute inset-0 bg-gradient-to-br from-indigo-800 via-purple-800 to-gray-900 dark:from-gray-950 dark:via-indigo-950 dark:to-black bg-[length:200%_200%] animate-gradientFlow">
    </div>
    <div class="relative max-w-7xl mx-auto px-6 py-20 z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
      <div class="lg:col-span-5 reveal-up">
        <div class="flex items-center space-x-3 mb-5">
          <i class="ri-home-heart-line text-3xl text-indigo-300"></i>
          <span class="text-2xl font-bold text-white">Hệ Thống Trọ</span>
        </div>
        <p class="text-gray-300/90 text-sm leading-relaxed">Nền tảng giúp kết nối người thuê và chủ trọ hiện đại — nhanh
          chóng, an toàn, tiện lợi chỉ trong vài phút.</p>
      </div>
      <div class="lg:col-span-4 grid grid-cols-2 gap-8 reveal-up anim-delay-150">
        <div>
          <h3 class="text-white font-semibold tracking-wider uppercase mb-5">Liên kết</h3>
          <ul class="space-y-3 text-sm">
            <li><a href="{{ route('home') }}" class="hover:text-indigo-300">Trang chủ</a></li>
            <li><a href="{{ route('listing') }}" class="hover:text-indigo-300">Danh sách trọ</a></li>
            <li><a href="/search" class="hover:text-indigo-300">Tìm kiếm</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-white font-semibold tracking-wider uppercase mb-5">Liên hệ</h3>
          <ul class="space-y-3 text-sm">
            <li><i class="ri-map-pin-line text-indigo-300 mr-2"></i> TP. Hồ Chí Minh</li>
            <li><i class="ri-mail-line text-indigo-300 mr-2"></i> support@hethongtro.vn</li>
            <li><i class="ri-phone-line text-indigo-300 mr-2"></i> 0123 456 789</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="mt-16 pt-8 border-t border-white/10 text-center text-sm text-gray-400">
      <p>© {{ date('Y') }} <a href="{{ route('home') }}" class="font-semibold text-indigo-300 hover:text-indigo-400">Hệ
          Thống Trọ</a>. Mọi quyền được bảo lưu.</p>
    </div>
  </footer>

  {{-- 🌙 Dark Mode Script --}}
  <script>
    function darkMode() {
      return {
        isDark: false,
        init() {
          const saved = localStorage.getItem('darkMode');
          this.isDark = saved ? JSON.parse(saved) : window.matchMedia('(prefers-color-scheme: dark)').matches;
          this.applyMode();
        },
        toggleDark() {
          this.isDark = !this.isDark;
          localStorage.setItem('darkMode', JSON.stringify(this.isDark));
          this.applyMode();
        },
        applyMode() {
          document.documentElement.classList.toggle('dark', this.isDark);
        }
      }
    }

    document.addEventListener("DOMContentLoaded", () => {
      const reveals = document.querySelectorAll(".reveal, .reveal-left, .reveal-right");
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("active");
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15 });
      reveals.forEach(el => observer.observe(el));
    });
  </script>

  @stack('scripts')
</body>

</html>