<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Date Availability
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Pilih paket wisata untuk mengelola ketersediaan tanggal.
        </p>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-5 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <form method="GET" action="{{ route('admin.date-availabilities.index') }}"
                    class="flex flex-col gap-3 sm:flex-row">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama paket wisata..."
                        class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                    >

                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Cari
                    </button>

                    <a href="{{ route('admin.date-availabilities.index') }}"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-center text-sm font-semibold text-gray-600 dark:text-gray-300">
                        Reset
                    </a>
                </form>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Paket Wisata</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Jenis</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Jumlah Option</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($travels as $travel)
                                <tr>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($travel->image1)
                                                <img
                                                    src="{{ asset('storage/' . $travel->image1) }}"
                                                    class="h-14 w-20 rounded-lg object-cover"
                                                    alt="{{ $travel->travel_name }}"
                                                >
                                            @endif

                                            <div>
                                                <div class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $travel->travel_name }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $travel->slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-sm">
                                        @if ($travel->is_corporate)
                                            <span class="rounded-full bg-purple-100 px-3 py-1 text-xs text-purple-700">
                                                Korporasi
                                            </span>
                                        @else
                                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-700">
                                                Reguler
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $travel->options_count }}
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <a href="{{ route('admin.date-availabilities.options', $travel) }}"
                                            class="inline-flex rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                                            Lihat Option →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center text-sm text-gray-500">
                                        Tidak ada paket wisata ditemukan.
                                    </td>
                                </tr>
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
