
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Kelola Date Availability
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ $option->travel?->travel_name ?? 'Paket Wisata' }}
            —
            {{ $option->name ?? $option->title ?? 'Option #' . $option->id }}
        </p>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a
                href="{{ route('admin.date-availabilities.options', $option->travel_id) }}"
                class="mb-5 inline-block text-sm font-medium text-blue-600 hover:underline"
            >
                ← Kembali ke Daftar Option
            </a>

            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TAMBAH TANGGAL --}}
            <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <h3 class="mb-5 text-lg font-semibold text-gray-900 dark:text-white">
                    Tambah Date Availability
                </h3>

                <form
                    action="{{ route('admin.date-availabilities.store', $option) }}"
                    method="POST"
                    class="flex flex-col gap-5 md:flex-row md:items-end"
                >
                    @csrf

                    <div class="flex-1">
                        <label for="date" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            id="date"
                            name="date"
                            value="{{ old('date') }}"
                            required
                            class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                        >
                    </div>

                    <div class="flex items-center gap-3 pb-2">
                        <input type="hidden" name="status" value="0">

                        <label class="relative inline-flex cursor-pointer items-center">
                            <input
                                type="checkbox"
                                name="status"
                                value="1"
                                class="peer sr-only"
                                @checked(old('status', '1') == '1')
                            >

                            <span class="h-6 w-11 rounded-full bg-gray-300 transition peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:after:translate-x-full"></span>
                        </label>

                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                            Tersedia
                        </span>
                    </div>

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        + Tambah Tanggal
                    </button>
                </form>

                <p class="mt-4 text-xs text-gray-500">
                    Tanggal yang belum terdaftar otomatis dianggap tersedia.
                </p>
            </div>

            {{-- DAFTAR TANGGAL --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <div class="border-b border-gray-200 p-5 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Daftar Tanggal
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                    Tanggal
                                </th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                    Status
                                </th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($availabilities as $availability)
                                <tr>
                                    <td class="px-5 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $availability->date->format('d M Y') }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($availability->status)
                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                Tidak Tersedia
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex justify-end gap-2">

                                            <button
                                                type="button"
                                                onclick="document.getElementById('edit-{{ $availability->id }}').classList.toggle('hidden')"
                                                class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 hover:bg-blue-100"
                                            >
                                                Edit
                                            </button>

                                            <form
                                                action="{{ route('admin.date-availabilities.destroy', $availability) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus tanggal ini? Setelah dihapus, tanggal akan dianggap tersedia.')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- FORM EDIT --}}
                                <tr id="edit-{{ $availability->id }}" class="hidden bg-blue-50/50 dark:bg-gray-900/40">
                                    <td colspan="3" class="px-5 py-5">
                                        <form
                                            action="{{ route('admin.date-availabilities.update', $availability) }}"
                                            method="POST"
                                            class="flex flex-col gap-4 md:flex-row md:items-end"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <div class="flex-1">
                                                <label class="mb-2 block text-xs font-semibold text-gray-600 dark:text-gray-300">
                                                    Tanggal
                                                </label>

                                                <input
                                                    type="date"
                                                    name="date"
                                                    value="{{ $availability->date->format('Y-m-d') }}"
                                                    required
                                                    class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                                >
                                            </div>

                                            <div class="flex items-center gap-3 pb-2">
                                                <input type="hidden" name="status" value="0">

                                                <label class="relative inline-flex cursor-pointer items-center">
                                                    <input
                                                        type="checkbox"
                                                        name="status"
                                                        value="1"
                                                        class="peer sr-only"
                                                        @checked($availability->status)
                                                    >

                                                    <span class="h-6 w-11 rounded-full bg-gray-300 transition peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:after:translate-x-full"></span>
                                                </label>

                                                <span class="text-sm text-gray-700 dark:text-gray-200">
                                                    Tersedia
                                                </span>
                                            </div>

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                                            >
                                                Simpan Perubahan
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-12 text-center text-sm text-gray-500">
                                        Belum ada tanggal yang diatur untuk option ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($availabilities->hasPages())
                    <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-700">
                        {{ $availabilities->withQueryString()->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
