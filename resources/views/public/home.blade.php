@extends('layouts.app')

@section('title', 'Trang chủ - Hệ Thống Trọ')

@section('content')
{{-- ====== Animation helpers (nhẹ, chỉ dùng tại view này) ====== --}}
<style>
  @keyframes fadeInUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
  .animate-fadeInUp { animation: fadeInUp .8s ease-out both; }
  .anim-delay-150 { animation-delay: .15s }
  .anim-delay-300 { animation-delay: .3s }
  @keyframes shine { 0%,100%{opacity:.2;transform:translateX(-30%) rotate(5deg)} 50%{opacity:.5;transform:translateX(30%) rotate(-5deg)} }
</style>
{{-- ============== HERO SECTION ============== --}}
<section class="relative overflow-hidden text-white reveal">

  {{-- 🌆 Background có hiệu ứng sáng nhẹ --}}
  <div class="absolute inset-0">
    <img src="{{ asset('images/bg-tro.jpg') }}" alt="Background"
         class="w-full h-full object-cover opacity-90 transition-all duration-[4000ms] ease-in-out reveal-bg">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-800/90 via-purple-700/80 to-blue-600/80"></div>
  </div>

  {{-- ✨ Content --}}
  <div class="relative z-10 max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-center">
    {{-- LEFT: Title --}}
    <div class="text-center md:text-left reveal-left">
      <span class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-1 rounded-full text-sm mb-5">
        <i class="ri-home-smile-line mr-2"></i> Nền tảng tìm phòng trọ #1 tại TP.HCM
      </span>

      <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">
        Tìm phòng trọ <span class="text-yellow-300 drop-shadow-md">hoàn hảo</span><br> chỉ trong vài phút
      </h1>

      <p class="text-white/90 mb-8 text-lg leading-relaxed">
        Khám phá hàng ngàn phòng trọ chất lượng cao với giá cả phù hợp.<br>
        Tìm kiếm thông minh, thuê nhanh chóng, sống thoải mái.
      </p>

      <div class="flex flex-wrap justify-center md:justify-start gap-4">
        <a href="{{ route('listing') }}"
           class="px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold rounded-xl shadow-lg transition transform hover:scale-[1.05] hover:shadow-yellow-300/40 flex items-center">
          <i class="ri-search-line mr-2"></i> Bắt đầu tìm kiếm
        </a>
        <a href="{{ route('chu-tro.index') }}"
           class="px-6 py-3 border-2 border-white/80 hover:bg-white/15 rounded-xl font-semibold transition transform hover:scale-[1.05]">
          <i class="ri-add-line mr-2"></i> Đăng tin cho thuê
        </a>
      </div>

      <div class="flex items-center justify-center md:justify-start mt-8 space-x-6 text-sm text-white/80">
        <div class="flex items-center">
          <div class="flex -space-x-2">
            @foreach([1,2,3] as $img)
              <img class="w-8 h-8 rounded-full border-2 border-white"
                   src="https://i.pravatar.cc/40?img={{ $img }}">
            @endforeach
          </div>
          <span class="ml-3">1000+ khách hàng tin tưởng</span>
        </div>
        <span>⭐ 4.9/5 đánh giá</span>
      </div>
    </div>

    {{-- RIGHT: Features --}}
    <div class="space-y-5 reveal-right">
      @foreach ([
        ['icon' => 'ri-search-line', 'color' => 'bg-yellow-400/90', 'title' => 'Tìm kiếm thông minh', 'desc' => 'Lọc theo vị trí, giá cả, tiện ích'],
        ['icon' => 'ri-shield-check-line', 'color' => 'bg-green-400/90', 'title' => 'An toàn & Tin cậy', 'desc' => 'Xác minh chủ nhà, đảm bảo chất lượng'],
        ['icon' => 'ri-headphone-line', 'color' => 'bg-purple-400/90', 'title' => 'Hỗ trợ 24/7', 'desc' => 'Tư vấn miễn phí, hỗ trợ tận tình']
      ] as $item)
        <div class="flex items-start bg-white/10 backdrop-blur-2xl rounded-2xl p-5 border border-white/20 hover:bg-white/20 transition transform hover:-translate-y-1 hover:shadow-lg">
          <div class="flex-shrink-0 w-12 h-12 rounded-full {{ $item['color'] }} flex items-center justify-center text-gray-900 text-xl mr-4 shadow-inner">
            <i class="{{ $item['icon'] }}"></i>
          </div>
          <div>
            <h3 class="font-semibold text-lg">{{ $item['title'] }}</h3>
            <p class="text-white/80 text-sm">{{ $item['desc'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Decorative Wave --}}
  <svg class="absolute bottom-0 left-0 w-full text-white" viewBox="0 0 1440 320" fill="currentColor">
    <path fill-opacity="0.2"
      d="M0,160L48,144C96,128,192,96,288,85.3C384,75,480,85,576,117.3C672,149,768,203,864,197.3C960,192,1056,128,1152,122.7C1248,117,1344,171,1392,197.3L1440,224V320H0Z">
    </path>
  </svg>
</section>


{{-- ============== STATISTICS ============== --}}
{{-- <section class="py-12 bg-white dark:bg-gray-900 text-center border-b dark:border-gray-700"> --}}
<section class="py-12 bg-white dark:bg-gray-900 text-center border-b dark:border-gray-700 reveal">
  <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 reveal-stagger">
    @foreach ([
      ['1000+', 'Phòng trọ', 'text-indigo-600'],
      ['500+', 'Khách hàng hài lòng', 'text-green-600'],
      ['24/7', 'Hỗ trợ', 'text-purple-600'],
      ['15+', 'Quận / Huyện', 'text-orange-500']
    ] as [$num, $label, $color])
      <div class="transform transition-all duration-700 ease-out hover:scale-105">
        <h3 class="text-3xl font-bold {{ $color }} counter" data-target="{{ intval($num) }}">{{ $num }}</h3>
        <p class="text-gray-600 dark:text-gray-300">{{ $label }}</p>
      </div>
    @endforeach
  </div>
</section>


{{-- ============== SEARCH FORM ============== --}}
{{-- <section class="relative py-16 bg-gray-50 dark:bg-gray-900" x-data="searchForm()"> --}}
<section class="relative py-16 bg-gray-50 dark:bg-gray-900 reveal" x-data="searchForm()">

  <div class="max-w-5xl mx-auto px-6">
    <div class="text-center mb-10">
      <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white">Tìm kiếm phòng trọ</h2>
      <p class="text-gray-500 dark:text-gray-300 mt-2">Sử dụng bộ lọc thông minh để tìm phòng trọ phù hợp nhất</p>
    </div>

    <form action="{{ route('listing') }}" method="GET" class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg p-8 space-y-6">
      {{-- Khu vực --}}
      <div>
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
          <i class="ri-map-pin-2-line mr-1 text-indigo-600"></i> Khu vực mong muốn
        </label>
        <div class="relative">
          <input type="text" name="area" placeholder="Nhập quận, huyện, đường..." x-model="filters.area"
            class="w-full px-5 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-indigo-500 placeholder-gray-400 text-gray-800 dark:text-gray-100 dark:bg-gray-900">
          <i class="ri-search-line absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
        </div>

        {{-- Khu vực phổ biến --}}
        <div class="mt-5">
          <p class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2 flex items-center">
            <i class="ri-map-pin-user-line mr-1 text-indigo-500"></i> Khu vực phổ biến
          </p>
          <div class="flex flex-wrap gap-2">
            @foreach (['Quận 1', 'Quận 3', 'Quận 7', 'Thủ Đức', 'Bình Thạnh', 'Quận 2'] as $kv)
              <button type="button"
                @click="toggleArea('{{ $kv }}')"
                :class="filters.area === '{{ $kv }}'
                  ? 'bg-indigo-600 text-white border-indigo-600 shadow-md'
                  : 'bg-gray-100 dark:bg-gray-900 hover:bg-indigo-50 text-gray-700 dark:text-gray-200 border-gray-200 dark:border-gray-700 hover:border-indigo-400'"
                class="px-4 py-1.5 rounded-full text-sm border shadow-sm hover:shadow transition">
                {{ $kv }}
              </button>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Khoảng giá --}}
      <div>
        <p class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2 flex items-center">
          <i class="ri-money-dollar-circle-line mr-1 text-indigo-500"></i> Khoảng giá mong muốn
        </p>
        <div class="flex items-center gap-3">
          <input type="number" x-model="filters.min" name="min_price" placeholder="Từ (₫)"
            class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 placeholder-gray-400 dark:bg-gray-900 dark:text-gray-100">
          <span class="text-gray-500 font-medium">—</span>
          <input type="number" x-model="filters.max" name="max_price" placeholder="Đến (₫)"
            class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 placeholder-gray-400 dark:bg-gray-900 dark:text-gray-100">
        </div>

        {{-- Gợi ý nhanh --}}
        <div class="flex flex-wrap gap-2 mt-3">
          @foreach (['< 2 triệu' => [0, 2000000], '2 - 3 triệu' => [2000000, 3000000], '3 - 5 triệu' => [3000000, 5000000], '> 5 triệu' => [5000000, 0]] as $label => $range)
            <button type="button"
              @click="setPrice({{ $range[0] }}, {{ $range[1] }})"
              :class="filters.min == {{ $range[0] }} && filters.max == {{ $range[1] }}
                ? 'bg-indigo-600 text-white border-indigo-600 shadow-md'
                : 'bg-gray-100 dark:bg-gray-900 hover:bg-indigo-50 text-gray-700 dark:text-gray-200 border-gray-200 dark:border-gray-700 hover:border-indigo-400'"
              class="px-4 py-1.5 rounded-full text-sm border shadow-sm hover:shadow transition">
              {{ $label }}
            </button>
          @endforeach
        </div>
      </div>

      {{-- Sắp xếp + Submit --}}
      <div class="flex items-end gap-4">
        <div class="flex-1">
          <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
            <i class="ri-sort-desc text-indigo-600 mr-1"></i> Sắp xếp theo
          </label>
          <select name="sort" x-model="filters.sort"
            class="w-full px-5 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-indigo-500 text-gray-800 dark:text-gray-100 dark:bg-gray-900">
            <option value="asc">Giá thấp → cao</option>
            <option value="desc">Giá cao → thấp</option>
            <option value="newest">Mới nhất</option>
            <option value="area">Diện tích lớn → nhỏ</option>
          </select>
        </div>

        <button type="submit"
          class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-2xl shadow-md hover:shadow-lg transition transform hover:scale-[1.03]">
          <i class="ri-search-eye-line mr-2"></i> Tìm kiếm ngay
        </button>
      </div>

      {{-- Bộ lọc nhanh --}}
      <div>
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">
          <i class="ri-filter-3-line text-indigo-600 mr-1"></i> Bộ lọc nhanh:
        </label>
        <div class="flex flex-wrap gap-3">
          <button type="button" @click="toggleFilter('Dưới 1.5M')"
            :class="filters.quick.includes('Dưới 1.5M') ? 'bg-green-100 border-green-400 text-green-700 ring-2 ring-green-300 shadow-md'
                  : 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-600 hover:bg-green-100'"
            class="px-4 py-2 rounded-full text-sm border transition flex items-center gap-1">
            <i class="ri-money-dollar-circle-line text-green-500 text-lg"></i>Dưới 1.5M
          </button>

          <button type="button" @click="toggleFilter('Gần trường ĐH')"
            :class="filters.quick.includes('Gần trường ĐH') ? 'bg-blue-100 border-blue-400 text-blue-700 ring-2 ring-blue-300 shadow-md'
                  : 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-600 hover:bg-blue-100'"
            class="px-4 py-2 rounded-full text-sm border transition flex items-center gap-1">
            <i class="ri-school-line text-blue-500 text-lg"></i>Gần trường ĐH
          </button>

          <button type="button" @click="toggleFilter('Có wifi')"
            :class="filters.quick.includes('Có wifi') ? 'bg-purple-100 border-purple-400 text-purple-700 ring-2 ring-purple-300 shadow-md'
                  : 'bg-purple-50 dark:bg-purple-900/20 border-purple-200 dark:border-purple-800 text-purple-600 hover:bg-purple-100'"
            class="px-4 py-2 rounded-full text-sm border transition flex items-center gap-1">
            <i class="ri-wifi-line text-purple-500 text-lg"></i>Có wifi
          </button>

          <button type="button" @click="toggleFilter('Có chỗ để xe')"
            :class="filters.quick.includes('Có chỗ để xe') ? 'bg-orange-100 border-orange-400 text-orange-700 ring-2 ring-orange-300 shadow-md'
                  : 'bg-orange-50 dark:bg-orange-900/20 border-orange-200 dark:border-orange-800 text-orange-600 hover:bg-orange-100'"
            class="px-4 py-2 rounded-full text-sm border transition flex items-center gap-1">
            <i class="ri-parking-box-line text-orange-500 text-lg"></i>Có chỗ để xe
          </button>

          <button type="button" @click="toggleFilter('Máy lạnh')"
            :class="filters.quick.includes('Máy lạnh') ? 'bg-cyan-100 border-cyan-400 text-cyan-700 ring-2 ring-cyan-300 shadow-md'
                  : 'bg-cyan-50 dark:bg-cyan-900/20 border-cyan-200 dark:border-cyan-800 text-cyan-600 hover:bg-cyan-100'"
            class="px-4 py-2 rounded-full text-sm border transition flex items-center gap-1">
            <i class="ri-snowflake-line text-cyan-500 text-lg"></i>Máy lạnh
          </button>

          <button type="button" @click="toggleFilter('Có gác lửng')"
            :class="filters.quick.includes('Có gác lửng') ? 'bg-pink-100 border-pink-400 text-pink-700 ring-2 ring-pink-300 shadow-md'
                  : 'bg-pink-50 dark:bg-pink-900/20 border-pink-200 dark:border-pink-800 text-pink-600 hover:bg-pink-100'"
            class="px-4 py-2 rounded-full text-sm border transition flex items-center gap-1">
            <i class="ri-home-4-line text-pink-500 text-lg"></i>Có gác lửng
          </button>
        </div>
      </div>

      {{-- Hidden --}}
      <template x-for="f in filters.quick" :key="f">
        <input type="hidden" name="filters[]" :value="f">
      </template>
    </form>
  </div>
</section>

{{-- Alpine helper --}}
<script>
  function searchForm() {
    return {
      filters: { area:'', min:'', max:'', sort:'asc', quick:[] },
      toggleArea(area){ this.filters.area = this.filters.area === area ? '' : area },
      setPrice(min,max){ this.filters.min=min; this.filters.max=max },
      toggleFilter(f){ this.filters.quick = this.filters.quick.includes(f) ? this.filters.quick.filter(x=>x!==f) : [...this.filters.quick,f] }
    }
  }
</script>

{{-- ============== FEATURED ROOMS ============== --}}
<section class="py-20 bg-white dark:bg-gray-900 reveal">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between mb-10">
      <div class="reveal-left">
        <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white">
          Phòng trọ nổi bật
        </h2>
        <p class="text-gray-500 dark:text-gray-300 mt-1">
          Được lựa chọn nhiều nhất trong tuần
        </p>
      </div>
      <div
        class="hidden sm:flex items-center gap-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-gray-600 dark:text-gray-300 text-sm shadow-sm reveal-right"
      >
        <i class="ri-search-eye-line text-indigo-500"></i>
        <span>Tìm thấy <b>6</b> phòng</span>
      </div>
    </div>

    {{-- Hiệu ứng xuất hiện lần lượt từng card --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 reveal-stagger">
      @foreach ([
        ['img' => 'room1.jpg', 'title' => 'Phòng trọ cao cấp Quận 1', 'area' => '25m²', 'price' => '1.200.000', 'district' => 'Quận 1, TP.HCM', 'tags' => ['Điều hòa', 'Wifi miễn phí', 'Máy giặt chung']],
        ['img' => 'room2.jpg', 'title' => 'Phòng trọ sinh viên giá rẻ', 'area' => '20m²', 'price' => '1.400.000', 'district' => 'Thủ Đức, TP.HCM', 'tags' => ['Gần trường ĐH', 'An ninh tốt', 'Giờ giấc tự do']],
        ['img' => 'room3.jpg', 'title' => 'Phòng trọ có gác lửng', 'area' => '30m²', 'price' => '1.600.000', 'district' => 'Bình Thạnh, TP.HCM', 'tags' => ['Gác lửng rộng', 'Cửa sổ lớn', 'Không gian thoáng']],
        ['img' => 'room4.jpg', 'title' => 'Phòng trọ full nội thất', 'area' => '28m²', 'price' => '1.800.000', 'district' => 'Quận 7, TP.HCM', 'tags' => ['Tủ lạnh', 'Lò vi sóng', 'Tủ quần áo']],
        ['img' => 'room5.jpg', 'title' => 'Phòng trọ view đẹp', 'area' => '35m²', 'price' => '2.000.000', 'district' => 'Quận 2, TP.HCM', 'tags' => ['View thành phố', 'Ban công rộng', 'Ánh sáng tự nhiên']],
        ['img' => 'room6.jpg', 'title' => 'Phòng trọ gần chợ', 'area' => '22m²', 'price' => '2.200.000', 'district' => 'Quận 3, TP.HCM', 'tags' => ['Gần chợ', 'Đi lại thuận tiện', 'Nhiều tiện ích']],
      ] as $idx => $room)
        <div
          class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700
                 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 ease-out"
        >
          <div class="relative overflow-hidden">
            <img
              src="{{ asset('upload/' . $room['img']) }}"
              onerror="this.src='{{ asset('upload/room1.jpg') }}'"
              alt="{{ $room['title'] }}"
              class="w-full h-56 object-cover transform group-hover:scale-110 transition-all duration-700 ease-out"
            >
            <div
              class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-70 transition duration-700"
            ></div>
            <span
              class="absolute top-3 left-3 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow animate-pulse"
            >🔥 HOT</span>
            <span
              class="absolute bottom-3 left-3 bg-indigo-600/90 text-white text-xs px-3 py-1 rounded-full flex items-center gap-1"
            >
              <i class="ri-ruler-line text-sm"></i> {{ $room['area'] }}
            </span>
            <button
              class="absolute top-3 right-3 bg-white/80 hover:bg-white text-gray-600 hover:text-red-500 rounded-full p-2 shadow transition"
            >
              <i class="ri-heart-line text-lg"></i>
            </button>
          </div>

          <div class="p-5">
            <div class="flex items-center justify-between mb-1">
              <h3
                class="text-lg font-semibold text-gray-800 dark:text-white leading-snug
                       group-hover:text-transparent group-hover:bg-clip-text
                       group-hover:bg-gradient-to-r group-hover:from-indigo-500 group-hover:to-purple-600
                       transition-all duration-500"
              >
                {{ $room['title'] }}
              </h3>
              <div class="flex items-center text-yellow-500 text-sm font-medium">
                <i class="ri-star-fill mr-1"></i> 4.8
              </div>
            </div>

            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm mb-3">
              <i class="ri-map-pin-line mr-1 text-indigo-500"></i> {{ $room['district'] }}
            </div>

            <div class="flex flex-wrap gap-2 mb-4">
              @foreach ($room['tags'] as $tag)
                <span
                  class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-300 text-xs font-medium rounded-full border border-indigo-100 dark:border-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition"
                >
                  {{ $tag }}
                </span>
              @endforeach
            </div>

            <div class="flex items-center justify-between">
              <div>
                <p class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                  {{ $room['price'] }}đ <span class="text-sm text-gray-400 font-normal">/tháng</span>
                </p>
                <p class="text-xs text-gray-400">~{{ rand(45, 75) }},000đ/m²</p>
              </div>
              <a
                href="{{ route('room.detail', $idx + 1) }}"
                class="px-5 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-semibold rounded-xl shadow hover:shadow-lg hover:scale-[1.05] transition"
              >
                <i class="ri-eye-line mr-1"></i> Xem chi tiết
              </a>
            </div>

            <div
              class="border-t dark:border-gray-700 mt-4 pt-3 flex justify-between text-sm text-gray-600 dark:text-gray-400"
            >
              <button class="flex items-center gap-1 hover:text-indigo-600 transition">
                <i class="ri-phone-line"></i> Gọi ngay
              </button>
              <button class="flex items-center gap-1 hover:text-indigo-600 transition">
                <i class="ri-chat-1-line"></i> Nhắn tin
              </button>
              <button class="flex items-center gap-1 hover:text-indigo-600 transition">
                <i class="ri-calendar-line"></i> Đặt lịch
              </button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>


{{-- 🌟 CTA SECTION: Bạn có phòng trọ cần cho thuê? --}}
<style>
/* ===== BASE ANIMATION ===== */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(25px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes ring {
  0%,100% { transform: rotate(0); }
  10%,30%,50%,70%,90% { transform: rotate(-3deg); }
  20%,40%,60%,80% { transform: rotate(3deg); }
}
.animate-fadeInUp { animation: fadeInUp 1s ease-out forwards; }
.animate-ring { animation: ring 1.5s ease-in-out infinite; animation-delay: 2s; }

/* ===== HIỆU ỨNG NỀN “THỞ + ÁNH SÁNG” ===== */
@keyframes fadeFocus {
  0%, 100% {
    transform: scale(1);
    filter: brightness(0.9) blur(0px);
    opacity: 0.9;
  }
  50% {
    transform: scale(1.05);
    filter: brightness(1.25) blur(1.5px);
    opacity: 1;
  }
}
.bg-panel {
  position: absolute;
  inset: 0;
  overflow: hidden;
  animation: fadeFocus 8s ease-in-out infinite;
  transition: filter 1s ease, opacity 1s ease, transform 1s ease;
}
.bg-panel::after {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(
    120deg,
    rgba(255,255,255,0) 0%,
    rgba(255,255,255,0.15) 50%,
    rgba(255,255,255,0) 100%
  );
  mix-blend-mode: overlay;
  animation: shimmerLight 10s ease-in-out infinite;
}
@keyframes shimmerLight {
  0% { transform: translateX(-100%) rotate(10deg); opacity: 0; }
  50% { transform: translateX(100%) rotate(10deg); opacity: 0.4; }
  100% { transform: translateX(200%) rotate(10deg); opacity: 0; }
}

/* ===== GLOW & SHIMMER TEXT ===== */
h2.bg-clip-text {
  position: relative;
  text-shadow: 0 0 15px rgba(255,255,255,0.3),
               0 0 25px rgba(255,255,0,0.2);
  animation: titleGlow 3s ease-in-out infinite alternate;
}
@keyframes titleGlow {
  0% { text-shadow: 0 0 15px rgba(255,255,255,0.3),0 0 25px rgba(255,255,150,0.2); }
  100% { text-shadow: 0 0 25px rgba(255,255,255,0.6),0 0 45px rgba(255,255,150,0.4); }
}
h2.bg-clip-text::after {
  content: "";
  position: absolute;
  top: 0;
  left: -75%;
  width: 50%;
  height: 100%;
  background: linear-gradient(120deg,
    rgba(255,255,255,0) 0%,
    rgba(255,255,255,0.6) 50%,
    rgba(255,255,255,0) 100%);
  animation: shimmer 4s infinite;
  transform: skewX(-20deg);
}
@keyframes shimmer {
  0% { left: -75%; }
  100% { left: 125%; }
}

/* ===== NÚT & HIỆU ỨNG ===== */
a.bg-white {
  position: relative;
  overflow: hidden;
  z-index: 1;
}
a.bg-white::before {
  content: "";
  position: absolute;
  inset: -2px;
  background: linear-gradient(90deg, #6366f1, #a855f7, #3b82f6);
  background-size: 300% 300%;
  border-radius: 1rem;
  opacity: 0;
  transition: opacity 0.3s ease-in-out;
  z-index: -1;
}
a.bg-white:hover::before {
  opacity: 1;
  animation: gradientShift 3s linear infinite;
}
@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
a.animate-ring {
  animation: ring 1.5s ease-in-out infinite,
             pulseBorder 2s ease-in-out infinite alternate;
}
@keyframes pulseBorder {
  0% { box-shadow: 0 0 5px rgba(255,255,255,0.3),
               0 0 10px rgba(255,255,255,0.2); }
  100% { box-shadow: 0 0 20px rgba(255,255,255,0.5),
               0 0 40px rgba(255,255,255,0.3); }
}

/* ===== PARTICLES ===== */
.particles {
  position: absolute;
  inset: 0;
  overflow: hidden;
  pointer-events: none;
  z-index: 2;
}
.particle {
  position: absolute;
  border-radius: 9999px;
  background: radial-gradient(circle,rgba(255,255,255,0.8)0%,rgba(255,255,255,0)70%);
  opacity: 0.6;
  animation: floatParticle linear infinite;
}
@keyframes floatParticle {
  0% { transform: translateY(0) scale(1); opacity: 0.7; }
  50% { transform: translateY(-20px) scale(1.1); opacity: 1; }
  100% { transform: translateY(0) scale(1); opacity: 0.7; }
}

/* ===== DARK MODE ===== */
.dark .particle {
  background: radial-gradient(circle, rgba(147,197,253,0.8) 0%, rgba(255,255,255,0) 70%);
  opacity: 0.4;
}
.dark .bg-panel {
  animation: fadeFocusDark 12s ease-in-out infinite;
  filter: brightness(0.85) saturate(1.2);
}
@keyframes fadeFocusDark {
  0%, 100% { filter: brightness(0.85) blur(0px); }
  50% { filter: brightness(1.1) blur(1.5px); }
}
.dark h2.bg-clip-text {
  background: linear-gradient(to right,#a5b4fc,#c4b5fd,#93c5fd);
  -webkit-background-clip: text;
  color: transparent;
}
/* === SCROLL REVEAL ANIMATION === */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(40px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInLeft {
  from { opacity: 0; transform: translateX(-40px); }
  to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInRight {
  from { opacity: 0; transform: translateX(40px); }
  to { opacity: 1; transform: translateX(0); }
}

.reveal { opacity: 0; }
.reveal.active { opacity: 1; animation: fadeInUp 0.8s ease-out forwards; }
.reveal-left.active { animation: fadeInLeft 0.8s ease-out forwards; }
.reveal-right.active { animation: fadeInRight 0.8s ease-out forwards; }

/* === STAGGERED APPEAR FOR MULTIPLE ITEMS === */
.reveal-stagger > * {
  opacity: 0;
  transform: translateY(25px);
  transition: all 0.6s ease-out;
}
.reveal-stagger.active > * {
  opacity: 1;
  transform: translateY(0);
}
.reveal-stagger.active > *:nth-child(1) { transition-delay: 0.1s; }
.reveal-stagger.active > *:nth-child(2) { transition-delay: 0.2s; }
.reveal-stagger.active > *:nth-child(3) { transition-delay: 0.3s; }
.reveal-stagger.active > *:nth-child(4) { transition-delay: 0.4s; }
.reveal-stagger.active > *:nth-child(5) { transition-delay: 0.5s; }
.reveal-stagger.active > *:nth-child(6) { transition-delay: 0.6s; }
.reveal-up {
  opacity: 0;
  transform: translateY(40px);
  transition: all 1s ease-out;
}
.reveal.active .reveal-up {
  opacity: 1;
  transform: translateY(0);
}
.reveal-bg {
  opacity: 0.4;
  transform: scale(1.1);
  transition: all 2s ease-out;
}
.reveal.active .reveal-bg {
  opacity: 1;
  transform: scale(1);
}

</style>

{{-- 🌟 CTA SECTION: Bạn có phòng trọ cần cho thuê? --}}
<section class="relative py-24 text-white text-center overflow-hidden reveal">

  {{-- 🌌 NỀN --}}  
  <div class="absolute inset-0 overflow-hidden reveal-bg">
    <div class="bg-panel">
      <img src="{{ asset('upload/room-bg.jpg') }}"
           alt="Background"
           class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-700/70 via-purple-600/70 to-blue-700/70"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_80%,rgba(255,255,255,0.15),transparent_70%)] 
                animate-[float_10s_ease-in-out_infinite_alternate]"></div>
  </div>

  {{-- ✨ PARTICLES --}}  
  <div class="particles reveal-stagger">
    @for ($i = 0; $i < 25; $i++)
      <span class="particle"
        style="
          width: {{ rand(6,14) }}px;
          height: {{ rand(6,14) }}px;
          top: {{ rand(0,100) }}%;
          left: {{ rand(0,100) }}%;
          animation-duration: {{ rand(8,14) }}s;
          animation-delay: -{{ rand(0,14) }}s;
        ">
      </span>
    @endfor
  </div>

  {{-- 🌟 NỘI DUNG --}}
  <div class="relative z-10 max-w-4xl mx-auto text-center text-white px-6 reveal-up">
    <h2 class="relative text-4xl md:text-5xl font-extrabold mb-5 drop-shadow-[0_2px_8px_rgba(0,0,0,0.4)]
               bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 via-white to-indigo-200">
      Bạn có phòng trọ cần cho thuê?
    </h2>

    <p class="mb-10 text-white/90 text-lg leading-relaxed">
      Đăng tin miễn phí và tiếp cận hàng nghìn khách hàng tiềm năng ngay hôm nay 🌟
    </p>

    <div class="flex flex-wrap justify-center gap-6">
      <a href="{{ route('chu-tro.create') }}"
         class="relative bg-white text-indigo-700 font-semibold px-8 py-3 rounded-2xl shadow-xl 
                hover:shadow-indigo-500/40 transition-all duration-300 hover:scale-[1.08] 
                hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-500 hover:text-white">
        <i class="ri-add-line mr-2"></i> Đăng tin miễn phí
      </a>

      <a href="#"
         class="relative border-2 border-white/70 px-8 py-3 rounded-2xl font-semibold text-white 
                hover:bg-white/10 hover:shadow-lg hover:shadow-white/30 transition-all duration-300 
                hover:scale-[1.08] animate-ring">
        <i class="ri-phone-line mr-2"></i> Liên hệ tư vấn
      </a>
    </div>
  </div>
</section>

{{-- ============== GOOGLE MAP (HCMC) ============== --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900 reveal">
  <div class="max-w-7xl mx-auto px-6 text-center">
    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3 reveal-up">
      📍 Bản đồ phòng trọ tại Thành phố Hồ Chí Minh
    </h3>
    <p class="text-gray-500 dark:text-gray-400 mb-6 reveal-up">
      Kéo, phóng to hoặc di chuyển để khám phá các khu vực trọ phổ biến
    </p>

    <div
      class="rounded-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-700 ease-out reveal-map">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.502388917805!2d106.6598629!3d10.7768894!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3872e5b41f%3A0x6e5c70e2a546f1e4!2zVGjDoG5oIHBo4buRIDIgSCDEkMO0IENow60gTWluaCBDaXR5!5e0!3m2!1svi!2s!4v1696772290169!5m2!1svi!2s"
        width="100%" height="450" style="border:0;" allowfullscreen loading="lazy"
        referrerpolicy="no-referrer-when-downgrade" class="w-full h-[450px] rounded-2xl">
      </iframe>
    </div>
  </div>
</section>


<script>
document.addEventListener("DOMContentLoaded", () => {
  const reveals = document.querySelectorAll(".reveal, .reveal-left, .reveal-right, .reveal-stagger");
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

@endsection
