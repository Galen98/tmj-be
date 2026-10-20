
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Analitik
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Website Analytics
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Pantau kunjungan website dan performa produk Travel Murah Jogja.
                    </p>
                </div>

                <form method="GET" action="{{ route('admin.dashboard.analytics') }}">
                    <select
                        name="days"
                        onchange="this.form.submit()"
                        class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white text-sm shadow-sm"
                    >
                        <option value="7" @selected($days == 7)>7 Hari Terakhir</option>
                        <option value="30" @selected($days == 30)>30 Hari Terakhir</option>
                        <option value="90" @selected($days == 90)>90 Hari Terakhir</option>
                    </select>
                </form>
            </div>

            {{-- OVERVIEW --}}
            @php
                $cards = [
                    [
                        'title' => 'Kunjungan Hari Ini',
                        'value' => $stats['today'],
                        'icon' => 'eye',
                        'color' => 'blue'
                    ],
                    [
                        'title' => 'Kunjungan Bulan Ini',
                        'value' => $stats['month'],
                        'icon' => 'calendar',
                        'color' => 'green'
                    ],
                    [
                        'title' => 'Total Page Views',
                        'value' => $stats['total'],
                        'icon' => 'chart',
                        'color' => 'purple'
                    ],
                    [
                        'title' => 'Pengunjung Unik',
                        'value' => $stats['unique'],
                        'icon' => 'users',
                        'color' => 'orange'
                    ],
                ];
            @endphp

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
                @foreach ($cards as $card)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                {{ $card['title'] }}
                            </span>
                            <span class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 flex items-center justify-center">
                                @if ($card['icon'] === 'eye')
                                    ◉
                                @elseif ($card['icon'] === 'calendar')
                                    ▦
                                @elseif ($card['icon'] === 'users')
                                    ♙
                                @else
                                    ▥
                                @endif
                            </span>
                        </div>

                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($card['value'], 0, ',', '.') }}
                        </h3>
                    </div>
                @endforeach
            </div>

            {{-- TRAFFIC CHART --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6">
                <div class="mb-5">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        Tren Kunjungan Website
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Page views dan pengunjung unik selama {{ $days }} hari terakhir.
                    </p>
                </div>

                <div class="relative h-64 sm:h-80">
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>

            {{-- TRAVEL PERFORMANCE --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            Travel Paling Populer
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Performa produk berdasarkan kunjungan halaman detail.
                        </p>
                    </div>

                    <span class="text-sm bg-blue-50 text-blue-700 px-3 py-1 rounded-full">
                        {{ number_format($stats['travelViews'], 0, ',', '.') }} views periode ini
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b dark:border-gray-700 text-gray-500 dark:text-gray-400">
                                <th class="text-left py-3 pr-4">Produk Travel</th>
                                <th class="text-right py-3 px-3">Periode Ini</th>
                                <th class="text-right py-3 pl-3">Total Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($travelStats as $index => $travel)
                                <tr class="border-b last:border-0 dark:border-gray-700">
                                    <td class="py-4 pr-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-7 h-7 flex-shrink-0 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-500 dark:text-gray-300">
                                                {{ $index + 1 }}
                                            </span>
                                            <span class="font-medium text-gray-800 dark:text-gray-100">
                                                {{ $travel->travel_name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-right py-4 px-3 font-semibold text-blue-600">
                                        {{ number_format($travel->period_views, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right py-4 pl-3 text-gray-600 dark:text-gray-300">
                                        {{ number_format($travel->total_views, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-400">
                                        Belum ada data travel.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- GEOGRAPHIC + DEVICES --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- PROVINCES --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                        Asal Pengunjung
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">
                        Distribusi kunjungan berdasarkan provinsi.
                    </p>

                    <div class="relative h-64">
                        <canvas id="provinceChart"></canvas>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse ($provinces as $province)
                            <div class="flex items-center justify-between text-sm gap-3">
                                <span class="text-gray-600 dark:text-gray-300 truncate">
                                    {{ $province->province }}
                                </span>
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($province->total, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 text-center">
                                Belum ada data lokasi.
                            </p>
                        @endforelse
                    </div>
                </div>

                {{-- DEVICES --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                        Perangkat Pengunjung
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">
                        Estimasi perangkat berdasarkan user agent.
                    </p>

                    <div class="relative h-64">
                        <canvas id="deviceChart"></canvas>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse ($deviceRows as $device)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-300">
                                    {{ $device->device }}
                                </span>
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($device->total, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 text-center">
                                Belum ada data perangkat.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- POPULAR PAGES + COUNTRIES --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- PAGES --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">
                        Halaman Paling Populer
                    </h3>

                    <div class="space-y-4">
                        @forelse ($popularPages as $page)
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm text-gray-600 dark:text-gray-300 break-all min-w-0">
                                    {{ $page->path }}
                                </span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white flex-shrink-0">
                                    {{ number_format($page->total, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">
                                Belum ada data halaman.
                            </p>
                        @endforelse
                    </div>
                </div>

                {{-- COUNTRIES --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">
                        Negara Asal Pengunjung
                    </h3>

                    <div class="space-y-4">
                        @forelse ($countries as $country)
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $country->country }}
                                </span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ number_format($country->total, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">
                                Belum ada data negara.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- RECENT ACTIVITY --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">
                    Aktivitas Kunjungan Terbaru
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b dark:border-gray-700 text-gray-500 dark:text-gray-400">
                                <th class="text-left py-3 pr-4">Halaman</th>
                                <th class="text-left py-3 px-3">Travel</th>
                                <th class="text-left py-3 px-3">Lokasi</th>
                                <th class="text-right py-3 pl-3">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentActivities as $activity)
                                <tr class="border-b last:border-0 dark:border-gray-700">
                                    <td class="py-3 pr-4 text-gray-700 dark:text-gray-200 break-all">
                                        {{ $activity->path ?: '-' }}
                                    </td>
                                    <td class="py-3 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $activity->travel_title ?: '-' }}
                                    </td>
                                    <td class="py-3 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $activity->province ?: ($activity->country ?: '-') }}
                                    </td>
                                    <td class="py-3 pl-3 text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($activity->created_at)->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-400">
                                        Belum ada aktivitas kunjungan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (typeof Chart === 'undefined') {
                console.error('Chart.js gagal dimuat.');
                return;
            }

            const traffic = @json($traffic);
            const provinces = @json($provinces);
            const devices = @json($deviceRows);

            const colors = [
                '#2563eb',
                '#10b981',
                '#f59e0b',
                '#8b5cf6',
                '#ef4444',
                '#06b6d4',
                '#64748b',
                '#ec4899'
            ];

            const trafficCanvas = document.getElementById('trafficChart');

            if (trafficCanvas) {
                new Chart(trafficCanvas, {
                    type: 'line',
                    data: {
                        labels: traffic.labels,
                        datasets: [
                            {
                                label: 'Page Views',
                                data: traffic.views,
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37,99,235,0.08)',
                                fill: true,
                                tension: 0.35,
                                pointRadius: 2
                            },
                            {
                                label: 'Pengunjung Unik Harian',
                                data: traffic.visitors,
                                borderColor: '#10b981',
                                backgroundColor: 'transparent',
                                tension: 0.35,
                                pointRadius: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            const provinceCanvas = document.getElementById('provinceChart');

            if (provinceCanvas && provinces.length > 0) {
                new Chart(provinceCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: provinces.map(item => item.province),
                        datasets: [{
                            data: provinces.map(item => Number(item.total)),
                            backgroundColor: colors,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            const deviceCanvas = document.getElementById('deviceChart');

            if (deviceCanvas && devices.length > 0) {
                new Chart(deviceCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: devices.map(item => item.device),
                        datasets: [{
                            data: devices.map(item => Number(item.total)),
                            backgroundColor: colors,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

        });
    </script>
</x-app-layout>
