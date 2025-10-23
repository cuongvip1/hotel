@extends('layouts.app')

@section('title', 'Bảng điều khiển Chủ trọ')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-6 space-y-10">

        {{-- 🔹 HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-3xl font-extrabold flex items-center gap-3 text-indigo-600 dark:text-indigo-400">
                <span
                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 text-white shadow-md">
                    <i class="ri-bar-chart-line text-xl"></i>
                </span>
                Bảng điều khiển chủ trọ
            </h1>
            <a href="{{ route('chu-tro.profile.show') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium shadow hover:shadow-lg hover:scale-[1.03] transition">
                <i class="ri-user-settings-line text-lg"></i> Hồ sơ cá nhân
            </a>
        </div>

        {{-- 🔹 THỐNG KÊ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
            @php
                $cards = [
                    ['label' => 'Dãy trọ', 'value' => $stats['so_day_tro'] ?? 0, 'icon' => 'ri-community-line', 'bg' => 'from-indigo-500 to-sky-500'],
                    ['label' => 'Phòng', 'value' => $stats['so_phong'] ?? 0, 'icon' => 'ri-building-2-line', 'bg' => 'from-blue-500 to-cyan-500'],
                    ['label' => 'Đang thuê', 'value' => $stats['so_phong_dang_thue'] ?? 0, 'icon' => 'ri-door-open-line', 'bg' => 'from-emerald-500 to-lime-500'],
                    ['label' => 'Phòng trống', 'value' => $stats['so_phong_trong'] ?? 0, 'icon' => 'ri-door-closed-line', 'bg' => 'from-amber-500 to-orange-500'],
                    ['label' => 'Doanh thu tháng', 'value' => number_format($stats['doanh_thu_thang'] ?? 0) . ' đ', 'icon' => 'ri-wallet-3-line', 'bg' => 'from-fuchsia-500 to-pink-500'],
                ];
            @endphp

            @foreach($cards as $c)
                <div
                    class="group rounded-2xl bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 p-5 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span
                                class="h-10 w-10 rounded-xl flex items-center justify-center text-white bg-gradient-to-tr {{ $c['bg'] }} shadow-md">
                                <i class="{{ $c['icon'] }}"></i>
                            </span>
                            <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $c['label'] }}</span>
                        </div>
                    </div>
                    <div class="mt-3 text-2xl font-semibold text-indigo-700 dark:text-indigo-300">
                        {{ $c['value'] }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 🔹 BIỂU ĐỒ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- 📈 Doanh thu 6 tháng --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2 text-gray-700 dark:text-gray-200">
                    <i class="ri-line-chart-line text-indigo-500"></i> Doanh thu 6 tháng gần nhất
                </h2>
                <canvas id="chartRevenue" height="120"></canvas>
            </div>

            {{-- 🧩 Biểu đồ tình trạng phòng --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2 text-gray-700 dark:text-gray-200">
                    <i class="ri-pie-chart-2-line text-indigo-500"></i> Tình trạng phòng
                </h2>
                <canvas id="chartOccupancy" height="120"></canvas>
                <div class="mt-5 grid grid-cols-3 text-center text-sm text-gray-600 dark:text-gray-400">
                    <div><span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span> Đang thuê</div>
                    <div><span class="inline-block h-2 w-2 rounded-full bg-amber-500"></span> Trống</div>
                    <div><span class="inline-block h-2 w-2 rounded-full bg-rose-500"></span> Đang sửa</div>
                </div>
            </div>
        </div>

        {{-- 🔹 DỮ LIỆU GẦN ĐÂY --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- 📰 Bài đăng gần đây --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2 text-gray-700 dark:text-gray-200">
                    <i class="ri-newspaper-line text-indigo-500"></i> Bài đăng gần đây
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-gray-700/40 text-gray-600 dark:text-gray-300">
                            <tr>
                                <th class="p-3 text-left">Tiêu đề</th>
                                <th class="p-3 text-right">Giá niêm yết</th>
                                <th class="p-3 text-center">Trạng thái</th>
                                <th class="p-3 text-center">Ngày đăng</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($bai_dang_gan_day as $b)
                                @php
                                    $badge = match ($b['trang_thai'] ?? '') {
                                        'duyet' => 'bg-emerald-100 text-emerald-700',
                                        'cho_duyet' => 'bg-amber-100 text-amber-700',
                                        'dang' => 'bg-indigo-100 text-indigo-700',
                                        'an' => 'bg-gray-100 text-gray-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-900 transition">
                                    <td class="p-3 font-medium">{{ $b['tieu_de'] }}</td>
                                    <td class="p-3 text-right text-indigo-600">{{ number_format($b['gia_niem_yet']) }} đ</td>
                                    <td class="p-3 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                            {{ $b['trang_thai'] }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center">
                                        {{ \Carbon\Carbon::parse($b['ngay_tao'] ?? now())->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-500">Chưa có bài đăng.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 🕒 Hoạt động gần đây --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 p-6">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2 text-gray-700 dark:text-gray-200">
                    <i class="ri-time-line text-indigo-500"></i> Hoạt động gần đây
                </h2>

                <ol class="relative border-s border-gray-200 dark:border-gray-700">
                    @forelse($hoat_dong_gan_day as $hd)
                        <li class="mb-6 ms-4">
                            <div class="absolute w-3 h-3 bg-indigo-500 rounded-full mt-1.5 -start-1.5"></div>
                            <time class="mb-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($hd['ngay_tao'] ?? now())->diffForHumans() }}
                            </time>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                {{ $hd['noi_dung'] ?? 'Hoạt động' }}
                            </p>
                        </li>
                    @empty
                        <li class="ms-4 text-gray-500">Chưa có hoạt động nào.</li>
                    @endforelse
                </ol>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const VND = new Intl.NumberFormat('vi-VN');
        const revenueData = @json($doanh_thu_6_thang ?? []);
        const occ = {
            dangThue: {{ (int) ($stats['so_phong_dang_thue'] ?? 0) }},
            trong: {{ (int) ($stats['so_phong_trong'] ?? 0) }},
            dangSua: {{ (int) ($stats['so_phong_dang_sua'] ?? 0) }},
        };

        // === Biểu đồ doanh thu ===
        (function () {
            const ctx = document.getElementById('chartRevenue').getContext('2d');
            const labels = Object.keys(revenueData);
            const values = Object.values(revenueData);
            const gradient = ctx.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, 'rgba(99,102,241,0.35)');
            gradient.addColorStop(1, 'rgba(99,102,241,0.03)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels.length ? labels.map(m => 'Thg ' + m.split('-')[1]) : ['Không có dữ liệu'],
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: values.length ? values : [0],
                        borderColor: '#4F46E5',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#4F46E5',
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: true, labels: { color: '#666' } },
                        tooltip: { callbacks: { label: ctx => ' ' + VND.format(ctx.parsed.y) + ' đ' } }
                    },
                    scales: {
                        x: { ticks: { color: '#666' }, grid: { color: '#ddd' } },
                        y: { beginAtZero: true, ticks: { callback: v => VND.format(v) + ' đ', color: '#666' } }
                    }
                }
            });
        })();

        // === Biểu đồ tình trạng phòng ===
        (function () {
            const ctx = document.getElementById('chartOccupancy').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Đang thuê', 'Trống', 'Đang sửa'],
                    datasets: [{
                        data: [occ.dangThue, occ.trong, occ.dangSua],
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '68%',
                    plugins: { legend: { display: false } },
                }
            });
        })();
    </script>
@endpush