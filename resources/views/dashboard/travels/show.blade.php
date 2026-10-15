<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <a
                        href="{{ route('admin.travels.index') }}"
                        class="hover:text-blue-600"
                    >
                        Paket Wisata
                    </a>

                    <span>/</span>
                    <span>Detail</span>
                </div>

                <h2 class="mt-2 text-xl font-semibold text-gray-800 dark:text-gray-100">
                    {{ $travel->travel_name }}
                </h2>

                <div class="mt-2 flex flex-wrap items-center gap-2">
                    @if ($travel->status)
                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-300">
                            Aktif
                        </span>
                    @else
                        <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                            Nonaktif
                        </span>
                    @endif

                    <span class="text-sm text-gray-500">
                        {{ $travel->city?->name ?? '-' }}
                    </span>

                    <span class="text-gray-300">•</span>

                    <span class="text-sm text-gray-500">
                        {{ $travel->duration }} {{ ucfirst($travel->duration_type) }}
                    </span>
                </div>
            </div>

            <div class="flex gap-2">
                <a
                    href="{{ route('admin.travels.index') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 dark:border-gray-600 dark:text-gray-200"
                >
                    Kembali
                </a>

                <a
                    href="{{ route('admin.travels.edit', $travel) }}"
                    class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    Edit Paket
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- GALLERY --}}
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                @php
                    $images = collect([
                        $travel->image1,
                        $travel->image2,
                        $travel->image3,
                        $travel->image4,
                        $travel->image5,
                    ])->filter();
                @endphp

                @if ($images->isNotEmpty())
                    <div class="grid grid-cols-2 gap-3 md:grid-cols-5">
                        @foreach ($images as $image)
                            <div class="aspect-[4/3] overflow-hidden rounded-xl bg-gray-100">
                                <img
                                    src="{{ asset('storage/' . $image) }}"
                                    alt="{{ $travel->travel_name }}"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-xl bg-gray-50 py-12 text-center text-sm text-gray-500 dark:bg-gray-900">
                        Belum ada gambar.
                    </div>
                @endif
            </section>

            {{-- GENERAL INFO --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm lg:col-span-2 dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Informasi Paket
                    </h3>

                    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500">
                                Kota
                            </dt>

                            <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $travel->city?->name ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500">
                                Point of Interest
                            </dt>

                            <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $travel->pointOfInterest?->name ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500">
                                Durasi
                            </dt>

                            <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $travel->duration }} {{ ucfirst($travel->duration_type) }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500">
                                Pickup
                            </dt>

                            <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $travel->is_pickup ? 'Ya' : 'Tidak' }}
                            </dd>
                        </div>

                        @if ($travel->is_pickup)
                            <div class="sm:col-span-2">
                                <dt class="text-xs uppercase tracking-wide text-gray-500">
                                    Lokasi Pickup
                                </dt>

                                <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $travel->pickup_venue ?: '-' }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </section>

                <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Harga
                    </h3>

                    <div class="mt-5">
                        @if ($travel->is_discount && $travel->price_discount)
                            <div class="text-sm text-gray-400 line-through">
                                Rp {{ number_format($travel->price_discount, 0, ',', '.') }}
                            </div>
                        @endif

                        <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            Rp {{ number_format($travel->price_now, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="mt-6 space-y-3 border-t border-gray-100 pt-5 text-sm dark:border-gray-700">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Corporate</span>
                            <span class="font-medium dark:text-gray-200">
                                {{ $travel->is_corporate ? 'Ya' : 'Tidak' }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Group</span>
                            <span class="font-medium dark:text-gray-200">
                                {{ $travel->is_group ? 'Ya' : 'Tidak' }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Anak</span>
                            <span class="font-medium dark:text-gray-200">
                                {{ $travel->is_children ? 'Ya' : 'Tidak' }}
                            </span>
                        </div>

                        @if ($travel->is_group)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Jumlah Peserta</span>
                                <span class="font-medium dark:text-gray-200">
                                    {{ $travel->jumlah_peserta ?? '-' }}
                                </span>
                            </div>
                        @endif
                    </div>
                </section>
            </div>

            {{-- DESCRIPTION --}}
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    Deskripsi
                </h3>

                <p class="mt-4 text-sm leading-6 text-gray-600 dark:text-gray-300">
                    {{ $travel->short_description }}
                </p>

                <div class="prose mt-6 max-w-none dark:text-white">
                    {!! $travel->full_description !!}
                </div>
            </section>

            {{-- TAGS & INCLUDES --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Tags
                    </h3>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @forelse ($travel->tags as $tag)
                            <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ $tag->name }}
                            </span>
                        @empty
                            <span class="text-sm text-gray-500">
                                Tidak ada tag.
                            </span>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Includes
                    </h3>

                    <div class="mt-4 space-y-3">
                        @forelse ($travel->includes as $include)
                            <div class="flex items-start gap-3 text-sm text-gray-700 dark:text-gray-300">
                                <span class="mt-0.5 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-xs text-green-600">
                                    ✓
                                </span>

                                <span>{{ $include->include_desc }}</span>
                            </div>
                        @empty
                            <span class="text-sm text-gray-500">
                                Tidak ada fasilitas.
                            </span>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- OPTIONS --}}
            <section class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Travel Options
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $travel->options->count() }} pilihan paket.
                    </p>
                </div>

                <div class="space-y-5 p-6">
                    @forelse ($travel->options as $option)
                        <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700">
                            <div class="bg-gray-50 px-5 py-4 dark:bg-gray-900/50">
                                <h4 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $option->option_name }}
                                </h4>

                                @if ($option->description)
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $option->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 gap-6 p-5 xl:grid-cols-3">

                                {{-- PRICE --}}
                                <div>
                                    <h5 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Harga Peserta
                                    </h5>

                                    <div class="space-y-2">
                                        @forelse ($option->prices as $price)
                                            <div class="rounded-lg bg-gray-50 p-3 text-sm dark:bg-gray-900/50">
                                                <div class="flex justify-between gap-3">
                                                    <div>
                                                        <div class="font-medium text-gray-700 dark:text-gray-200">
                                                            {{ $price->label }}
                                                        </div>

                                                        <div class="mt-0.5 text-xs text-gray-500">
                                                            {{ $price->min }}
                                                            -
                                                            {{ $price->max ?? '∞' }}
                                                            peserta
                                                        </div>
                                                    </div>

                                                    <div class="whitespace-nowrap font-semibold text-gray-900 dark:text-white">
                                                        Rp {{ number_format($price->price, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500">
                                                Tidak ada harga.
                                            </p>
                                        @endforelse
                                    </div>
                                </div>

                                {{-- TIME --}}
                                <div>
                                    <h5 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Waktu
                                    </h5>

                                    <div class="flex flex-wrap gap-2">
                                        @forelse ($option->times as $time)
                                            <span class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ substr($time->time, 0, 5) }}
                                            </span>
                                        @empty
                                            <p class="text-sm text-gray-500">
                                                Tidak ada waktu.
                                            </p>
                                        @endforelse
                                    </div>
                                </div>

                                {{-- ADDON --}}
                                <div>
                                    <h5 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                        Add Ons
                                    </h5>

                                    <div class="space-y-2">
                                        @forelse ($option->addons as $addon)
                                            <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-900/50">
                                                <div class="flex justify-between gap-3">
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                                            {{ $addon->addon_name }}
                                                        </div>

                                                        @if ($addon->description)
                                                            <div class="mt-1 text-xs text-gray-500">
                                                                {{ $addon->description }}
                                                            </div>
                                                        @endif

                                                        <div class="mt-1 text-xs text-gray-400">
                                                            Min {{ $addon->min }}
                                                            •
                                                            Max {{ $addon->max }}
                                                        </div>
                                                    </div>

                                                    <div class="whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                                        Rp {{ number_format($addon->price, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500">
                                                Tidak ada add on.
                                            </p>
                                        @endforelse
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center text-sm text-gray-500">
                            Belum ada travel option.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
