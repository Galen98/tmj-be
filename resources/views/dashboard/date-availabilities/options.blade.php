<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Option Paket Wisata
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ $travel->travel_name }}
        </p>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('admin.date-availabilities.index') }}"
                class="mb-5 inline-block text-sm font-medium text-blue-600 hover:underline">
                ← Kembali ke Paket Wisata
            </a>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Nama Option</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Tanggal Diatur</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($options as $option)
                                <tr>
                                    <td class="px-5 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $option->option_name ?? $option->title ?? 'Option #' . $option->id }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $option->date_availabilities_count }} tanggal
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <a href="{{ route('admin.date-availabilities.manage', $option) }}"
                                            class="inline-flex rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                                            Kelola Tanggal →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-12 text-center text-sm text-gray-500">
                                        Belum ada option untuk paket wisata ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
