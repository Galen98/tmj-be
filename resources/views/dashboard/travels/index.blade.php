<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                    Paket Wisata
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola seluruh paket wisata Travel Murah Jogja.
                </p>
            </div>

            <a
                href="{{ route('admin.travels.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
            >
                <span class="text-lg leading-none">+</span>
                Tambah Paket
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-950/30 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif


{{-- SEARCH & FILTER --}}
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">

    <form
        action="{{ route('admin.travels.index') }}"
        method="GET"
        class="flex flex-col gap-4 lg:flex-row lg:items-end"
    >

            {{-- SEARCH NAMA PAKET --}}
            <div class="flex-1">
                <label
                    for="search"
                    class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200"
                >
                    Cari Paket Wisata
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Masukkan nama paket wisata..."
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                >
            </div>

            {{-- FILTER KORPORASI --}}
            <div class="w-full lg:w-56">
                <label
                    for="corporate"
                    class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200"
                >
                    Jenis Paket
                </label>

                <select
                    id="corporate"
                    name="corporate"
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                >
                    <option value="" @selected(request('corporate', '') === '')>
                        Semua Paket
                    </option>

                    <option value="1" @selected(request('corporate') === '1')>
                        Korporasi
                    </option>

                    <option value="0" @selected(request('corporate') === '0')>
                        Non-Korporasi
                    </option>
                </select>
            </div>

            {{-- ACTION --}}
            <div class="flex items-center gap-2">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                >
                    Cari & Filter
                </button>

                <a
                    href="{{ route('admin.travels.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Reset
                </a>
            </div>
        </form>
    </div>

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Paket
                                </th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Lokasi
                                </th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Durasi
                                </th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Harga
                                </th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Option
                                </th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Status
                                </th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($travels as $travel)
                                <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                    <td class="px-5 py-4">
                                        <div class="flex min-w-[280px] items-center gap-4">
                                            <div class="h-16 w-24 flex-shrink-0 overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-700">
                                                @if ($travel->image1)
                                                    <img
                                                        src="{{ asset('storage/' . $travel->image1) }}"
                                                        alt="{{ $travel->travel_name }}"
                                                        class="h-full w-full object-cover"
                                                    >
                                                @else
                                                    <div class="flex h-full items-center justify-center text-xs text-gray-400">
                                                        No Image
                                                    </div>
                                                @endif
                                            </div>

                                            <div>
                                                <div class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $travel->travel_name }}
                                                </div>

                                                <div class="mt-1 max-w-[250px] truncate text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $travel->slug }}
                                                </div>

                                                @if ($travel->is_corporate)
                                                    <span class="mt-2 inline-flex rounded-full bg-purple-100 px-2 py-0.5 text-[11px] font-medium text-purple-700 dark:bg-purple-900/30 dark:text-purple-300">
                                                        Corporate
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-sm">
                                        <div class="font-medium text-gray-700 dark:text-gray-200">
                                            {{ $travel->city?->name ?? '-' }}
                                        </div>

                                        <div class="mt-1 text-xs text-gray-500">
                                            {{ $travel->pointOfInterest?->name ?? 'Tanpa POI' }}
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $travel->duration }} {{ ucfirst($travel->duration_type) }}
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4">
                                        @if ($travel->is_discount && $travel->price_discount)
                                            <div class="text-xs text-gray-400 line-through">
                                                Rp {{ number_format($travel->price_discount, 0, ',', '.') }}
                                            </div>
                                        @endif

                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            Rp {{ number_format($travel->price_now, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $travel->options_count ?? $travel->options->count() }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($travel->status)
                                            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a
                                                href="{{ route('admin.travels.show', $travel) }}"
                                                class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700"
                                            >
                                                Detail
                                            </a>

                                            <a
                                                href="{{ route('admin.travels.edit', $travel) }}"
                                                class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-medium text-blue-600 transition hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.travels.destroy', $travel) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus paket wisata ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg bg-red-50 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-100 dark:bg-red-900/30 dark:text-red-300"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                @if (request()->filled('search') || request()->filled('corporate'))
                                    <div class="text-base font-medium text-gray-700 dark:text-gray-200">
                                        Paket wisata tidak ditemukan
                                    </div>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Tidak ada paket wisata yang sesuai dengan pencarian atau filter.
                                    </p>
                                @else
                                    <div class="text-base font-medium text-gray-700 dark:text-gray-200">
                                        Belum ada paket wisata
                                    </div>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Tambahkan paket wisata pertama untuk mulai menampilkan produk.
                                    </p>
                                @endif
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($travels->hasPages())
                    <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-700">
                        {{ $travels->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
