@php
    /*
    |--------------------------------------------------------------------------
    | Initial Form Data
    |--------------------------------------------------------------------------
    */

    $selectedTags = old(
        'tags',
        $travel?->tags?->pluck('id')->values()->toArray() ?? []
    );

    $includesData = old(
        'includes',
        $travel
            ? $travel->includes->map(fn ($include) => [
                'id' => $include->id,
                'include_desc' => $include->include_desc,
            ])->values()->toArray()
            : []
    );

    $optionsData = old(
        'options',
        $travel
            ? $travel->options->map(fn ($option) => [
                'id' => $option->id,
                'option_name' => $option->option_name,
                'description' => $option->description,
                'status' => $option->status === null ? true : filter_var($option->status, FILTER_VALIDATE_BOOLEAN),

                'prices' => $option->prices->map(fn ($price) => [
                    'id' => $price->id,
                    'type' => $price->type,
                    'label' => $price->label,
                    'min' => $price->min,
                    'max' => $price->max,
                    'price' => $price->price,
                ])->values()->toArray(),

                'times' => $option->times->map(fn ($time) => [
                    'id' => $time->id,
                    'time' => substr($time->time, 0, 5),
                ])->values()->toArray(),

                'addons' => $option->addons->map(fn ($addon) => [
                    'id' => $addon->id,
                    'addon_name' => $addon->addon_name,
                    'description' => $addon->description,
                    'price' => $addon->price,
                    'min' => $addon->min,
                    'max' => $addon->max,
                ])->values()->toArray(),
            ])->values()->toArray()
            : []
    );
@endphp




<div
    x-data="travelForm({
        travelName: @js(old('travel_name', $travel?->travel_name ?? '')),
        slug: @js(old('slug', $travel?->slug ?? '')),

        tags: @js($selectedTags),
        includes: @js($includesData),
        options: @js($optionsData),

        isPickup: @js((bool) old(
            'is_pickup',
            $travel?->is_pickup ?? false
        )),

        isGroup: @js((bool) old(
            'is_group',
            $travel?->is_group ?? false
        )),

        isDiscount: @js((bool) old(
            'is_discount',
            $travel?->is_discount ?? false
        ))
    })"
    x-init="
        options = options.map(option => ({
            ...option,
            status: option.status === undefined
                ? true
                : toBooleanStatus(option.status)
        }))
    "
>

    {{-- ========================================================= --}}
    {{-- VALIDATION ERROR --}}
    {{-- ========================================================= --}}

    @if ($errors->any())
        <div
            class="rounded-xl border border-red-200 bg-red-50 p-5
                   dark:border-red-900/50 dark:bg-red-950/30"
        >
            <div class="flex items-start gap-3">
                <div
                    class="flex h-8 w-8 flex-shrink-0 items-center
                           justify-center rounded-full bg-red-100
                           font-bold text-red-600
                           dark:bg-red-900/50 dark:text-red-300"
                >
                    !
                </div>

                <div>
                    <h3 class="font-semibold text-red-700 dark:text-red-300">
                        Data belum dapat disimpan
                    </h3>

                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                        Periksa kembali beberapa data berikut.
                    </p>

                    <ul
                        class="mt-3 list-disc space-y-1 pl-5
                               text-sm text-red-600 dark:text-red-400"
                    >
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- INFORMASI UTAMA --}}
    {{-- ========================================================= --}}

    <section
        class="rounded-2xl border border-gray-200 bg-white shadow-sm
               dark:border-gray-700 dark:bg-gray-800"
    >
        <div
            class="border-b border-gray-100 px-6 py-5
                   dark:border-gray-700"
        >
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                Informasi Utama
            </h3>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Informasi dasar paket yang akan dilihat customer.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

            {{-- Travel Name --}}
            <div class="md:col-span-2">
                <label
                    for="travel_name"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Nama Paket
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="travel_name"
                    type="text"
                    name="travel_name"
                    x-model="travelName"
                    @input="updateSlug()"
                    value="{{ old('travel_name', $travel?->travel_name) }}"
                    placeholder="Contoh: Borobudur Sunrise Tour"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           dark:border-gray-600 dark:bg-gray-900
                           dark:text-white"
                >

                @error('travel_name')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Slug --}}
            <div class="md:col-span-2">
                <label
                    for="slug"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Slug
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="slug"
                    type="text"
                    name="slug"
                    x-model="slug"
                    @input="slugTouched = true"
                    value="{{ old('slug', $travel?->slug) }}"
                    placeholder="borobudur-sunrise-tour"
                    required
                    readonly
                    class="w-full rounded-lg border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           dark:border-gray-600 dark:bg-gray-900
                           dark:text-white"
                >

                <p class="mt-1.5 text-xs text-gray-500">
                    Digunakan sebagai URL detail paket.
                </p>

                @error('slug')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- City --}}
            <div>
                <label
                    for="cities_id"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Kota
                    <span class="text-red-500">*</span>
                </label>

                <select
                    id="cities_id"
                    name="cities_id"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           dark:border-gray-600 dark:bg-gray-900
                           dark:text-white"
                >
                    <option value="">
                        Pilih Kota
                    </option>

                    @foreach ($cities as $city)
                        <option
                            value="{{ $city->id }}"
                            @selected(
                                old(
                                    'cities_id',
                                    $travel?->cities_id
                                ) == $city->id
                            )
                        >
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>

                @error('cities_id')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Point of Interest --}}
            <div>
                <label
                    for="point_of_interest_id"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Point of Interest
                </label>

                <select
                    id="point_of_interest_id"
                    name="point_of_interest_id"
                    class="w-full rounded-lg border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           dark:border-gray-600 dark:bg-gray-900
                           dark:text-white"
                >
                    <option value="">
                        Tidak Ada
                    </option>

                    @foreach ($pointOfInterests as $poi)
                        <option
                            value="{{ $poi->id }}"
                            @selected(
                                old(
                                    'point_of_interest_id',
                                    $travel?->point_of_interest_id
                                ) == $poi->id
                            )
                        >
                            {{ $poi->name }}
                        </option>
                    @endforeach
                </select>

                @error('point_of_interest_id')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Short Description --}}
            <div class="md:col-span-2">
                <label
                    for="short_description"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Deskripsi Singkat
                    <span class="text-red-500">*</span>
                </label>

                <textarea
                    id="short_description"
                    name="short_description"
                    rows="3"
                    maxlength="500"
                    required
                    placeholder="Deskripsi singkat paket wisata..."
                    class="w-full rounded-lg border-gray-300 shadow-sm
                           focus:border-blue-500 focus:ring-blue-500
                           dark:border-gray-600 dark:bg-gray-900
                           dark:text-white"
                >{{ old('short_description', $travel?->short_description) }}</textarea>

                @error('short_description')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Full Description --}}
            <div class="md:col-span-2">
                <label
                    for="full_description"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Deskripsi Lengkap
                    <span class="text-red-500">*</span>
                </label>

                <textarea
                    id="full_description"
                    name="full_description"
                >{{ old('full_description', $travel?->full_description) }}</textarea>

                @error('full_description')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- DURASI --}}
    {{-- ========================================================= --}}

    <section
        class="rounded-2xl border border-gray-200 bg-white shadow-sm
               dark:border-gray-700 dark:bg-gray-800 mt-4"
    >
        <div
            class="border-b border-gray-100 px-6 py-5
                   dark:border-gray-700"
        >
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                Durasi
            </h3>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Tentukan lama perjalanan paket.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

            <div>
                <label
                    for="duration"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Durasi
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="duration"
                    type="number"
                    min="1"
                    name="duration"
                    value="{{ old('duration', $travel?->duration) }}"
                    required
                    class="w-full rounded-lg border-gray-300
                           dark:border-gray-600 dark:bg-gray-900
                           dark:text-white"
                >

                @error('duration')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <div>
                <label
                    for="duration_type"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Satuan Durasi
                    <span class="text-red-500">*</span>
                </label>

                <select
                    id="duration_type"
                    name="duration_type"
                    required
                    class="w-full rounded-lg border-gray-300
                           dark:border-gray-600 dark:bg-gray-900
                           dark:text-white"
                >
                    <option
                        value="jam"
                        @selected(
                            old(
                                'duration_type',
                                $travel?->duration_type ?? 'jam'
                            ) === 'jam'
                        )
                    >
                        Jam
                    </option>

                    <option
                        value="hari"
                        @selected(
                            old(
                                'duration_type',
                                $travel?->duration_type
                            ) === 'hari'
                        )
                    >
                        Hari
                    </option>
                </select>

                @error('duration_type')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- PENGATURAN PAKET --}}
    {{-- ========================================================= --}}

    <section
        class="rounded-2xl border border-gray-200 bg-white shadow-sm
               dark:border-gray-700 dark:bg-gray-800 mt-4"
    >
        <div
            class="border-b border-gray-100 px-6 py-5
                   dark:border-gray-700"
        >
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                Pengaturan Paket
            </h3>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Atur tipe dan fasilitas utama paket.
            </p>
        </div>

        <div class="p-6">

            <div
                class="grid grid-cols-1 gap-4
                       sm:grid-cols-2 lg:grid-cols-4"
            >

                {{-- Pickup --}}
                <label
                    class="flex cursor-pointer items-center justify-between
                           rounded-xl border border-gray-200 p-4
                           dark:border-gray-700"
                >
                    <span
                        class="text-sm font-medium
                               text-gray-700 dark:text-gray-300"
                    >
                        Pickup
                    </span>

                    <input
                        type="hidden"
                        name="is_pickup"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="is_pickup"
                        value="1"
                        x-model="isPickup"
                        class="h-4 w-4 rounded border-gray-300
                               text-blue-600 focus:ring-blue-500"
                    >
                </label>


                {{-- Corporate --}}
                <label
                    class="flex cursor-pointer items-center justify-between
                           rounded-xl border border-gray-200 p-4
                           dark:border-gray-700"
                >
                    <span
                        class="text-sm font-medium
                               text-gray-700 dark:text-gray-300"
                    >
                        Corporate
                    </span>

                    <input
                        type="hidden"
                        name="is_corporate"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="is_corporate"
                        value="1"
                        @checked(
                            old(
                                'is_corporate',
                                $travel?->is_corporate ?? false
                            )
                        )
                        class="h-4 w-4 rounded border-gray-300
                               text-blue-600 focus:ring-blue-500"
                    >
                </label>


                {{-- Group --}}
                <label
                    class="flex cursor-pointer items-center justify-between
                           rounded-xl border border-gray-200 p-4
                           dark:border-gray-700"
                >
                    <span
                        class="text-sm font-medium
                               text-gray-700 dark:text-gray-300"
                    >
                        Group
                    </span>

                    <input
                        type="hidden"
                        name="is_group"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="is_group"
                        value="1"
                        x-model="isGroup"
                        class="h-4 w-4 rounded border-gray-300
                               text-blue-600 focus:ring-blue-500"
                    >
                </label>


                {{-- Children --}}
                <label
                    class="flex cursor-pointer items-center justify-between
                           rounded-xl border border-gray-200 p-4
                           dark:border-gray-700"
                >
                    <span
                        class="text-sm font-medium
                               text-gray-700 dark:text-gray-300"
                    >
                        Anak
                    </span>

                    <input
                        type="hidden"
                        name="is_children"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="is_children"
                        value="1"
                        @checked(
                            old(
                                'is_children',
                                $travel?->is_children ?? false
                            )
                        )
                        class="h-4 w-4 rounded border-gray-300
                               text-blue-600 focus:ring-blue-500"
                    >
                </label>
            </div>


            <div
                class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2"
            >

                {{-- Pickup Venue --}}
                <div
                    x-show="isPickup"
                    x-transition
                    x-cloak
                >
                    <label
                        for="pickup_venue"
                        class="mb-2 block text-sm font-medium
                               text-gray-700 dark:text-gray-300"
                    >
                        Lokasi Pickup
                    </label>

                    <input
                        id="pickup_venue"
                        type="text"
                        name="pickup_venue"
                        value="{{ old('pickup_venue', $travel?->pickup_venue) }}"
                        placeholder="Hotel atau penginapan area Yogyakarta"
                        class="w-full rounded-lg border-gray-300
                               dark:border-gray-600 dark:bg-gray-900
                               dark:text-white"
                    >

                    @error('pickup_venue')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Jumlah Peserta --}}
                <div
                    x-show="isGroup"
                    x-transition
                    x-cloak
                >
                    <label
                        for="jumlah_peserta"
                        class="mb-2 block text-sm font-medium
                               text-gray-700 dark:text-gray-300"
                    >
                        Jumlah Peserta
                    </label>

                    <input
                        id="jumlah_peserta"
                        type="number"
                        min="1"
                        name="jumlah_peserta"
                        value="{{ old('jumlah_peserta', $travel?->jumlah_peserta) }}"
                        class="w-full rounded-lg border-gray-300
                               dark:border-gray-600 dark:bg-gray-900
                               dark:text-white"
                    >

                    @error('jumlah_peserta')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- HARGA DISPLAY --}}
    {{-- ========================================================= --}}

    <section
        class="rounded-2xl border border-gray-200 bg-white shadow-sm
               dark:border-gray-700 dark:bg-gray-800 mt-4"
    >
        <div
            class="border-b border-gray-100 px-6 py-5
                   dark:border-gray-700"
        >
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                Harga Display
            </h3>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Harga utama yang ditampilkan pada card produk.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-3">

            {{-- Price Now --}}
            <div>
                <label
                    for="price_now"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Harga Sekarang
                    <span class="text-red-500">*</span>
                </label>

                <div class="flex">
                    <span
                        class="inline-flex items-center rounded-l-lg
                               border border-r-0 border-gray-300
                               bg-gray-100 px-3 text-sm text-gray-500
                               dark:border-gray-600 dark:bg-gray-700
                               dark:text-gray-300"
                    >
                        Rp
                    </span>

                    <input
                        id="price_now"
                        type="number"
                        min="0"
                        name="price_now"
                        value="{{ old('price_now', $travel?->price_now) }}"
                        placeholder="500000"
                        required
                        class="w-full rounded-r-lg border-gray-300
                               dark:border-gray-600 dark:bg-gray-900
                               dark:text-white"
                    >
                </div>

                @error('price_now')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Discount --}}
            <div>
                <label
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Diskon
                </label>

                <label
                    class="flex h-[42px] cursor-pointer items-center
                           justify-between rounded-lg border
                           border-gray-300 px-4
                           dark:border-gray-600"
                >
                    <span
                        class="text-sm text-gray-600
                               dark:text-gray-300"
                    >
                        Aktifkan Diskon
                    </span>

                    <input
                        type="hidden"
                        name="is_discount"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="is_discount"
                        value="1"
                        x-model="isDiscount"
                        class="rounded border-gray-300 text-blue-600"
                    >
                </label>
            </div>


            {{-- Discount Price --}}
            <div
                x-show="isDiscount"
                x-transition
                x-cloak
            >
                <label
                    for="price_discount"
                    class="mb-2 block text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Harga Sebelum Diskon
                </label>

                <div class="flex">
                    <span
                        class="inline-flex items-center rounded-l-lg
                               border border-r-0 border-gray-300
                               bg-gray-100 px-3 text-sm text-gray-500
                               dark:border-gray-600 dark:bg-gray-700
                               dark:text-gray-300"
                    >
                        Rp
                    </span>

                    <input
                        id="price_discount"
                        type="number"
                        min="0"
                        name="price_discount"
                        value="{{ old('price_discount', $travel?->price_discount) }}"
                        placeholder="600000"
                        class="w-full rounded-r-lg border-gray-300
                               dark:border-gray-600 dark:bg-gray-900
                               dark:text-white"
                    >
                </div>

                @error('price_discount')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- GALLERY --}}
    {{-- ========================================================= --}}

    <section
        class="rounded-2xl border border-gray-200 bg-white shadow-sm
               dark:border-gray-700 dark:bg-gray-800 mt-4"
    >
        <div
            class="border-b border-gray-100 px-6 py-5
                   dark:border-gray-700"
        >
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                Galeri
            </h3>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Gambar 1 digunakan sebagai gambar utama paket.
                Maksimal 5 MB per gambar.
            </p>
        </div>

        <div
            class="grid grid-cols-1 gap-4 p-6
                   sm:grid-cols-2 lg:grid-cols-5"
        >
            @for ($i = 1; $i <= 5; $i++)
                @php
                    $field = 'image' . $i;
                    $currentImage = $travel?->{$field};
                @endphp

                <div
                    x-data="travelImage(
                        @js(
                            $currentImage
                                ? asset('storage/' . $currentImage)
                                : null
                        )
                    )"
                    class="overflow-hidden rounded-xl border
                           border-gray-200 dark:border-gray-700"
                >
                    <div
                        class="aspect-[4/3] bg-gray-100
                               dark:bg-gray-900"
                    >
                        <template x-if="preview">
                            <img
                                :src="preview"
                                alt="Preview"
                                class="h-full w-full object-cover"
                            >
                        </template>

                        <template x-if="!preview">
                            <div
                                class="flex h-full items-center justify-center
                                       px-3 text-center text-xs text-gray-400"
                            >
                                Belum ada gambar
                            </div>
                        </template>
                    </div>

                    <div class="p-3">
                        <div
                            class="mb-2 text-sm font-medium
                                   text-gray-700 dark:text-gray-300"
                        >
                            Gambar {{ $i }}

                            @if ($i === 1)
                                <span class="text-red-500">*</span>
                            @endif
                        </div>

                        <input
                            type="file"
                            name="{{ $field }}"
                            accept="image/*"
                            @change="change($event)"
                            @if ($i === 1 && !$travel)
                                required
                            @endif
                            class="block w-full text-xs text-gray-500
                                   file:mr-2 file:rounded-lg file:border-0
                                   file:bg-gray-100 file:px-3 file:py-2
                                   file:text-xs file:font-medium
                                   dark:file:bg-gray-700
                                   dark:file:text-gray-200"
                        >

                        @error($field)
                            <p class="mt-2 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            @endfor
        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- TAGS --}}
    {{-- ========================================================= --}}

    <section
        class="rounded-2xl border border-gray-200 bg-white shadow-sm
               dark:border-gray-700 dark:bg-gray-800 mt-4"
    >
        <div
            class="flex flex-col gap-4 border-b border-gray-100
                   px-6 py-5 sm:flex-row sm:items-center
                   sm:justify-between dark:border-gray-700"
        >
            <div>
                <h3
                    class="text-base font-semibold
                           text-gray-900 dark:text-white"
                >
                    Tags
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Pilih tag yang berhubungan dengan paket ini.
                </p>
            </div>

            <button
                type="button"
                @click="addTag()"
                class="rounded-lg border border-blue-200 bg-blue-50
                       px-3 py-2 text-sm font-medium text-blue-600
                       transition hover:bg-blue-100
                       dark:border-blue-900 dark:bg-blue-900/20
                       dark:text-blue-300"
            >
                + Tambah Tag
            </button>
        </div>

        <div class="space-y-3 p-6">

            <template x-if="tags.length === 0">
                <div
                    class="rounded-xl border border-dashed
                           border-gray-300 p-6 text-center
                           text-sm text-gray-500
                           dark:border-gray-600"
                >
                    Belum ada tag.
                </div>
            </template>

            <template
                x-for="(tag, tagIndex) in tags"
                :key="tag.key"
            >
                <div class="flex gap-3">
                    <select
                        x-model="tag.id"
                        :name="`tags[${tagIndex}]`"
                        class="flex-1 rounded-lg border-gray-300
                               dark:border-gray-600 dark:bg-gray-900
                               dark:text-white"
                    >
                        <option value="">
                            Pilih Tag
                        </option>

                        @foreach ($tags as $masterTag)
                            <option value="{{ $masterTag->id }}">
                                {{ $masterTag->name }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        type="button"
                        @click="removeTag(tagIndex)"
                        class="rounded-lg bg-red-50 px-4
                               text-sm font-medium text-red-600
                               transition hover:bg-red-100
                               dark:bg-red-900/20 dark:text-red-300"
                    >
                        Hapus
                    </button>
                </div>
            </template>
        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- INCLUDES --}}
    {{-- ========================================================= --}}

    <section
        class="rounded-2xl border border-gray-200 bg-white shadow-sm
               dark:border-gray-700 dark:bg-gray-800 mt-4"
    >
        <div
            class="flex flex-col gap-4 border-b border-gray-100
                   px-6 py-5 sm:flex-row sm:items-center
                   sm:justify-between dark:border-gray-700"
        >
            <div>
                <h3
                    class="text-base font-semibold
                           text-gray-900 dark:text-white"
                >
                    Fasilitas / Includes
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Fasilitas yang sudah termasuk dalam paket.
                </p>
            </div>

            <button
                type="button"
                @click="addInclude()"
                class="rounded-lg border border-blue-200 bg-blue-50
                       px-3 py-2 text-sm font-medium text-blue-600
                       transition hover:bg-blue-100
                       dark:border-blue-900 dark:bg-blue-900/20
                       dark:text-blue-300"
            >
                + Tambah Include
            </button>
        </div>

        <div class="space-y-3 p-6">

            <template x-if="includes.length === 0">
                <div
                    class="rounded-xl border border-dashed
                           border-gray-300 p-6 text-center
                           text-sm text-gray-500
                           dark:border-gray-600"
                >
                    Belum ada fasilitas.
                </div>
            </template>

            <template
                x-for="(include, includeIndex) in includes"
                :key="include.key"
            >
                <div class="flex gap-3">

                    <input
                        type="hidden"
                        :name="`includes[${includeIndex}][id]`"
                        :value="include.id"
                    >

                    <input
                        type="text"
                        x-model="include.include_desc"
                        :name="`includes[${includeIndex}][include_desc]`"
                        placeholder="Contoh: Transportasi selama perjalanan"
                        class="flex-1 rounded-lg border-gray-300
                               dark:border-gray-600 dark:bg-gray-900
                               dark:text-white"
                    >

                    <button
                        type="button"
                        @click="removeInclude(includeIndex)"
                        class="rounded-lg bg-red-50 px-4
                               text-sm font-medium text-red-600
                               transition hover:bg-red-100
                               dark:bg-red-900/20 dark:text-red-300"
                    >
                        Hapus
                    </button>
                </div>
            </template>
        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- TRAVEL OPTIONS --}}
    {{-- ========================================================= --}}

    <section
        class="rounded-2xl border border-gray-200 bg-white shadow-sm
               dark:border-gray-700 dark:bg-gray-800 mt-4"
    >
        <div
            class="flex flex-col gap-4 border-b border-gray-100
                   px-6 py-5 sm:flex-row sm:items-center
                   sm:justify-between dark:border-gray-700"
        >
            <div>
                <h3
                    class="text-base font-semibold
                           text-gray-900 dark:text-white"
                >
                    Travel Options
                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Setiap option memiliki harga, waktu keberangkatan,
                    dan add on sendiri.
                </p>
            </div>

            <button
                type="button"
                @click="addOption()"
                class="rounded-lg bg-blue-600 px-4 py-2
                       text-sm font-semibold text-white
                       transition hover:bg-blue-700"
            >
                + Tambah Option
            </button>
        </div>

        <div class="space-y-6 p-6">

            <template
                x-for="(option, optionIndex) in options"
                :key="option.key"
            >
                <div
                    class="overflow-hidden rounded-2xl border
                           border-gray-200 dark:border-gray-700"
                >

                    <input
                        type="hidden"
                        :name="`options[${optionIndex}][id]`"
                        :value="option.id"
                    >


                    {{-- Option Header --}}
                    <div class="flex items-center gap-3">

                    {{-- STATUS OPTION: switch Alpine + hidden field --}}
                    <label class="inline-flex cursor-pointer select-none items-center gap-3 rounded-xl border border-gray-200 px-3 py-2 dark:border-gray-700">
                        <input
                            type="hidden"
                            :name="`options[${optionIndex}][status]`"
                            :value="option.status ? '1' : '0'"
                        >
                        <input
                            type="checkbox"
                            class="peer sr-only"
                             :checked="option.status === true"
                            @change="option.status = $event.target.checked"
                        >
                        <span class="relative h-6 w-11 rounded-full bg-gray-300 transition-colors peer-checked:bg-blue-600 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-400 dark:bg-gray-600">
                            <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform"
                                  :class="option.status ? 'translate-x-5' : 'translate-x-0'"></span>
                        </span>
                        <span class="text-xs font-semibold"
                              :class="option.status ? 'text-green-600' : 'text-red-600'"
                              x-text="option.status ? 'Aktif' : 'Nonaktif'"></span>
                    </label>

                    {{-- DELETE OPTION --}}
                    <button
                        type="button"
                        @click="removeOption(optionIndex)"
                        class="rounded-lg bg-red-50 px-3 py-2
                            text-xs font-medium text-red-600
                            transition hover:bg-red-100"
                    >
                        Hapus Option
                    </button>

                </div>


                    <div class="space-y-8 p-5">

                        {{-- Option Basic --}}
                        <div
                            class="grid grid-cols-1 gap-4
                                   md:grid-cols-2"
                        >

                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-medium text-gray-700
                                           dark:text-gray-300"
                                >
                                    Nama Option
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    x-model="option.option_name"
                                    :name="`options[${optionIndex}][option_name]`"
                                    placeholder="Borobudur Sunrise Reguler"
                                    required
                                    class="w-full rounded-lg
                                           border-gray-300
                                           dark:border-gray-600
                                           dark:bg-gray-900
                                           dark:text-white"
                                >
                            </div>


                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-medium text-gray-700
                                           dark:text-gray-300"
                                >
                                    Deskripsi
                                </label>

                                <input
                                    type="text"
                                    x-model="option.description"
                                    :name="`options[${optionIndex}][description]`"
                                    placeholder="Keterangan singkat option"
                                    class="w-full rounded-lg
                                           border-gray-300
                                           dark:border-gray-600
                                           dark:bg-gray-900
                                           dark:text-white"
                                >
                            </div>
                        </div>


                        {{-- ================================================= --}}
                        {{-- OPTION PRICES --}}
                        {{-- ================================================= --}}

                        <div
                            class="rounded-xl border border-gray-200
                                   dark:border-gray-700"
                        >
                            <div
                                class="flex flex-col gap-3 border-b
                                       border-gray-200 px-4 py-3
                                       sm:flex-row sm:items-center
                                       sm:justify-between
                                       dark:border-gray-700"
                            >
                                <div>
                                    <h5
                                        class="text-sm font-semibold
                                               text-gray-800
                                               dark:text-gray-200"
                                    >
                                        Harga Peserta
                                    </h5>

                                    <p class="mt-0.5 text-xs text-gray-500">
                                        Harga berdasarkan tipe dan jumlah peserta.
                                    </p>
                                </div>

                                <button
                                    type="button"
                                    @click="addPrice(option)"
                                    class="rounded-lg bg-blue-50
                                           px-3 py-2 text-xs
                                           font-medium text-blue-600
                                           transition hover:bg-blue-100
                                           dark:bg-blue-900/20
                                           dark:text-blue-300"
                                >
                                    + Tambah Harga
                                </button>
                            </div>

                            <div class="space-y-3 p-4">

                                <template
                                    x-for="
                                        (price, priceIndex)
                                        in option.prices
                                    "
                                    :key="price.key"
                                >
                                    <div
                                        class="grid grid-cols-1 gap-3
                                               rounded-xl bg-gray-50 p-4
                                               md:grid-cols-12
                                               dark:bg-gray-900/40"
                                    >

                                        <input
                                            type="hidden"
                                            :name="`options[${optionIndex}][prices][${priceIndex}][id]`"
                                            :value="price.id"
                                        >


                                        {{-- Type --}}
                                        <div class="md:col-span-2">
                                            <label
                                                class="text-xs font-medium
                                                       text-gray-500"
                                            >
                                                Tipe
                                            </label>

                                            <select
                                                x-model="price.type"
                                                :name="`options[${optionIndex}][prices][${priceIndex}][type]`"
                                                required
                                                class="mt-1 w-full rounded-lg
                                                       border-gray-300 text-sm
                                                       dark:border-gray-600
                                                       dark:bg-gray-900
                                                       dark:text-white"
                                            >
                                                <option value="person">
                                                    Dewasa
                                                </option>

                                                <option value="child">
                                                    Anak
                                                </option>
                                            </select>
                                        </div>


                                        {{-- Label --}}
                                        <input
                                            type="hidden"
                                            :name="`options[${optionIndex}][prices][${priceIndex}][label]`"
                                            :value="price.type === 'person' ? 'Dewasa' : 'Anak'"
                                        >


                                        {{-- Min --}}
                                        <div class="md:col-span-1">
                                            <label
                                                class="text-xs font-medium
                                                       text-gray-500"
                                            >
                                                Min
                                            </label>

                                            <input
                                                type="number"
                                                min="0"
                                                x-model="price.min"
                                                :name="`options[${optionIndex}][prices][${priceIndex}][min]`"
                                                required
                                                class="mt-1 w-full rounded-lg
                                                       border-gray-300 text-sm
                                                       dark:border-gray-600
                                                       dark:bg-gray-900
                                                       dark:text-white"
                                            >
                                        </div>


                                        {{-- Max --}}
                                        <div class="md:col-span-1">
                                            <label
                                                class="text-xs font-medium
                                                       text-gray-500"
                                            >
                                                Max
                                            </label>

                                            <input
                                                type="number"
                                                x-model="price.max"
                                                :name="`options[${optionIndex}][prices][${priceIndex}][max]`"
                                                min="0"
                                                required
                                                class="mt-1 w-full rounded-lg
                                                       border-gray-300 text-sm
                                                       dark:border-gray-600
                                                       dark:bg-gray-900
                                                       dark:text-white"
                                            >
                                        </div>


                                        {{-- Price --}}
                                        <div class="md:col-span-4">
                                            <label
                                                class="text-xs font-medium
                                                       text-gray-500"
                                            >
                                                Harga
                                            </label>

                                            <div class="mt-1 flex">
                                                <span
                                                    class="inline-flex
                                                           items-center
                                                           rounded-l-lg border
                                                           border-r-0
                                                           border-gray-300
                                                           bg-gray-100 px-3
                                                           text-sm
                                                           text-gray-500
                                                           dark:border-gray-600
                                                           dark:bg-gray-700"
                                                >
                                                    Rp
                                                </span>

                                                <input
                                                    type="number"
                                                    x-model="price.price"
                                                    :name="`options[${optionIndex}][prices][${priceIndex}][price]`"
                                                    required
                                                    min="0"
                                                    class="w-full rounded-r-lg
                                                           border-gray-300
                                                           text-sm
                                                           dark:border-gray-600
                                                           dark:bg-gray-900
                                                           dark:text-white"
                                                >
                                            </div>
                                        </div>


                                        {{-- Delete --}}
                                        <div
                                            class="flex items-end
                                                   md:col-span-2"
                                        >
                                            <button
                                                type="button"
                                                @click="
                                                    removePrice(
                                                        option,
                                                        priceIndex
                                                    )
                                                "
                                                class="h-[42px] w-full
                                                       rounded-lg bg-red-50
                                                       text-xs font-medium
                                                       text-red-600
                                                       transition
                                                       hover:bg-red-100
                                                       dark:bg-red-900/20
                                                       dark:text-red-300"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>


                        {{-- ================================================= --}}
                        {{-- OPTION TIMES --}}
                        {{-- ================================================= --}}

                        <div
                            class="rounded-xl border border-gray-200
                                   dark:border-gray-700"
                        >
                            <div
                                class="flex flex-col gap-3 border-b
                                       border-gray-200 px-4 py-3
                                       sm:flex-row sm:items-center
                                       sm:justify-between
                                       dark:border-gray-700"
                            >
                                <div>
                                    <h5
                                        class="text-sm font-semibold
                                               text-gray-800
                                               dark:text-gray-200"
                                    >
                                        Waktu Keberangkatan
                                    </h5>

                                    <p class="mt-0.5 text-xs text-gray-500">
                                        Jam yang tersedia untuk option ini.
                                    </p>
                                </div>

                                <button
                                    type="button"
                                    @click="addTime(option)"
                                    class="rounded-lg bg-blue-50
                                           px-3 py-2 text-xs
                                           font-medium text-blue-600
                                           transition hover:bg-blue-100
                                           dark:bg-blue-900/20
                                           dark:text-blue-300"
                                >
                                    + Tambah Waktu
                                </button>
                            </div>

                            <div class="p-4">

                                <template
                                    x-if="option.times.length === 0"
                                >
                                    <div
                                        class="rounded-lg border
                                               border-dashed
                                               border-gray-300 p-4
                                               text-center text-xs
                                               text-gray-500
                                               dark:border-gray-600"
                                    >
                                        Belum ada waktu keberangkatan.
                                    </div>
                                </template>

                                <div class="flex flex-wrap gap-3">
                                    <template
                                        x-for="
                                            (time, timeIndex)
                                            in option.times
                                        "
                                        :key="time.key"
                                    >
                                        <div
                                            class="flex items-center gap-2
                                                   rounded-xl bg-gray-50 p-2
                                                   dark:bg-gray-900/50"
                                        >
                                            <input
                                                type="hidden"
                                                :name="`options[${optionIndex}][times][${timeIndex}][id]`"
                                                :value="time.id"
                                            >

                                            <input
                                                type="time"
                                                x-model="time.time"
                                                :name="`options[${optionIndex}][times][${timeIndex}][time]`"
                                                required
                                                class="rounded-lg
                                                       border-gray-300
                                                       text-sm
                                                       dark:border-gray-600
                                                       dark:bg-gray-900
                                                       dark:text-white"
                                            >

                                            <button
                                                type="button"
                                                @click="
                                                    removeTime(
                                                        option,
                                                        timeIndex
                                                    )
                                                "
                                                class="rounded-lg px-2.5
                                                       py-2 text-sm
                                                       text-red-600
                                                       transition
                                                       hover:bg-red-50
                                                       dark:hover:bg-red-900/20"
                                            >
                                                ×
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>


                        {{-- ================================================= --}}
                        {{-- OPTION ADDONS --}}
                        {{-- ================================================= --}}

                        <div
                            class="rounded-xl border border-gray-200
                                   dark:border-gray-700"
                        >
                            <div
                                class="flex flex-col gap-3 border-b
                                       border-gray-200 px-4 py-3
                                       sm:flex-row sm:items-center
                                       sm:justify-between
                                       dark:border-gray-700"
                            >
                                <div>
                                    <h5
                                        class="text-sm font-semibold
                                               text-gray-800
                                               dark:text-gray-200"
                                    >
                                        Add Ons
                                    </h5>

                                    <p class="mt-0.5 text-xs text-gray-500">
                                        Tambahan yang dapat dipilih customer
                                        untuk option ini.
                                    </p>
                                </div>

                                <button
                                    type="button"
                                    @click="addAddon(option)"
                                    class="rounded-lg bg-blue-50
                                           px-3 py-2 text-xs
                                           font-medium text-blue-600
                                           transition hover:bg-blue-100
                                           dark:bg-blue-900/20
                                           dark:text-blue-300"
                                >
                                    + Tambah Add On
                                </button>
                            </div>

                            <div class="space-y-3 p-4">

                                <template
                                    x-if="option.addons.length === 0"
                                >
                                    <div
                                        class="rounded-lg border
                                               border-dashed
                                               border-gray-300 p-4
                                               text-center text-xs
                                               text-gray-500
                                               dark:border-gray-600"
                                    >
                                        Belum ada add on.
                                    </div>
                                </template>

                                <template
                                    x-for="
                                        (addon, addonIndex)
                                        in option.addons
                                    "
                                    :key="addon.key"
                                >
                                    <div
                                        class="grid grid-cols-1 gap-3
                                               rounded-xl bg-gray-50 p-4
                                               md:grid-cols-12
                                               dark:bg-gray-900/40"
                                    >

                                        <input
                                            type="hidden"
                                            :name="`options[${optionIndex}][addons][${addonIndex}][id]`"
                                            :value="addon.id"
                                        >


                                        {{-- Name --}}
                                        <div class="md:col-span-3">
                                            <label
                                                class="text-xs font-medium
                                                       text-gray-500"
                                            >
                                                Nama Add On
                                            </label>

                                            <input
                                                type="text"
                                                x-model="addon.addon_name"
                                                :name="`options[${optionIndex}][addons][${addonIndex}][addon_name]`"
                                                placeholder="Fotografer"
                                                required
                                                class="mt-1 w-full rounded-lg
                                                       border-gray-300
                                                       text-sm
                                                       dark:border-gray-600
                                                       dark:bg-gray-900
                                                       dark:text-white"
                                            >
                                        </div>


                                        {{-- Description --}}
                                        <div class="md:col-span-3">
                                            <label
                                                class="text-xs font-medium
                                                       text-gray-500"
                                            >
                                                Deskripsi
                                            </label>

                                            <input
                                                type="text"
                                                x-model="addon.description"
                                                :name="`options[${optionIndex}][addons][${addonIndex}][description]`"
                                                placeholder="Dokumentasi perjalanan"
                                                class="mt-1 w-full rounded-lg
                                                       border-gray-300
                                                       text-sm
                                                       dark:border-gray-600
                                                       dark:bg-gray-900
                                                       dark:text-white"
                                            >
                                        </div>


                                        {{-- Price --}}
                                        <div class="md:col-span-2">
                                            <label
                                                class="text-xs font-medium
                                                       text-gray-500"
                                            >
                                                Harga
                                            </label>

                                            <input
                                                type="number"
                                                min="0"
                                                x-model="addon.price"
                                                :name="`options[${optionIndex}][addons][${addonIndex}][price]`"
                                                required
                                                class="mt-1 w-full rounded-lg
                                                       border-gray-300
                                                       text-sm
                                                       dark:border-gray-600
                                                       dark:bg-gray-900
                                                       dark:text-white"
                                            >
                                        </div>


                                        {{-- Min --}}
                                        <div class="md:col-span-1">
                                            <label
                                                class="text-xs font-medium
                                                       text-gray-500"
                                            >
                                                Min
                                            </label>

                                            <input
                                                type="number"
                                                min="0"
                                                x-model="addon.min"
                                                :name="`options[${optionIndex}][addons][${addonIndex}][min]`"
                                                required
                                                class="mt-1 w-full rounded-lg
                                                       border-gray-300
                                                       text-sm
                                                       dark:border-gray-600
                                                       dark:bg-gray-900
                                                       dark:text-white"
                                            >
                                        </div>


                                        {{-- Max --}}
                                        <div class="md:col-span-1">
                                            <label
                                                class="text-xs font-medium
                                                       text-gray-500"
                                            >
                                                Max
                                            </label>

                                            <input
                                                type="number"
                                                min="0"
                                                x-model="addon.max"
                                                :name="`options[${optionIndex}][addons][${addonIndex}][max]`"
                                                required
                                                class="mt-1 w-full rounded-lg
                                                       border-gray-300
                                                       text-sm
                                                       dark:border-gray-600
                                                       dark:bg-gray-900
                                                       dark:text-white"
                                            >
                                        </div>


                                        {{-- Delete --}}
                                        <div
                                            class="flex items-end
                                                   md:col-span-2"
                                        >
                                            <button
                                                type="button"
                                                @click="
                                                    removeAddon(
                                                        option,
                                                        addonIndex
                                                    )
                                                "
                                                class="h-[42px] w-full
                                                       rounded-lg bg-red-50
                                                       text-xs font-medium
                                                       text-red-600
                                                       transition
                                                       hover:bg-red-100
                                                       dark:bg-red-900/20
                                                       dark:text-red-300"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- STATUS --}}
    {{-- ========================================================= --}}

    <section
        class="rounded-2xl border border-gray-200 bg-white shadow-sm
               dark:border-gray-700 dark:bg-gray-800 mt-4"
    >
        <div
            class="flex flex-col gap-4 p-6
                   sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">
                    Status Paket
                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Paket aktif dapat ditampilkan kepada customer.
                </p>
            </div>

            <label
                class="flex items-center gap-3 rounded-lg border
                       border-gray-200 px-4 py-3
                       dark:border-gray-700"
            >
                <input
                    type="hidden"
                    name="status"
                    value="0"
                >

                <input
                    type="checkbox"
                    name="status"
                    value="1"
                    @checked(
                        old(
                            'status',
                            $travel?->status ?? true
                        )
                    )
                    class="h-5 w-5 rounded border-gray-300
                           text-blue-600 focus:ring-blue-500"
                >

                <span
                    class="text-sm font-medium
                           text-gray-700 dark:text-gray-300"
                >
                    Aktif
                </span>
            </label>
        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- SUBMIT --}}
    {{-- ========================================================= --}}

    <div
        class="sticky bottom-4 z-30 flex items-center justify-between
               rounded-2xl border border-gray-200 bg-white/95 p-4
               shadow-xl backdrop-blur
               dark:border-gray-700 dark:bg-gray-800/95 mt-4"
    >
        <div class="hidden text-sm text-gray-500 sm:block">
            Pastikan semua informasi paket sudah benar.
        </div>

        <div class="ml-auto flex gap-3">
            <a
                href="{{ route('admin.travels.index') }}"
                class="rounded-lg border border-gray-300
                       px-5 py-2.5 text-sm font-medium
                       text-gray-700 transition hover:bg-gray-50
                       dark:border-gray-600 dark:text-gray-200
                       dark:hover:bg-gray-700"
            >
                Batal
            </a>

            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-6 py-2.5
                       text-sm font-semibold text-white shadow-sm
                       transition hover:bg-blue-700"
            >
                {{ $travel ? 'Simpan Perubahan' : 'Simpan Paket' }}
            </button>
        </div>
    </div>
</div>


{{-- ============================================================= --}}
{{-- SCRIPT --}}
{{-- ============================================================= --}}

@push('scripts')
<script>
    window.travelForm = function (data) {
        return {
            tags: [],
            includes: [],
            options: [],

            isPickup: false,
            isGroup: false,
            isDiscount: false,

            toBooleanStatus(value) {
                if (value === null || value === undefined || value === '') return true;
                return value === true || value === 1 ||
                    (typeof value === 'string' &&
                     ['1', 'true', 'on', 'yes'].includes(value.trim().toLowerCase()));
            },

            init() {
                this.isPickup =
                    Boolean(data.isPickup);

                this.isGroup =
                    Boolean(data.isGroup);

                this.isDiscount =
                    Boolean(data.isDiscount);


                /*
                |--------------------------------------------------------------------------
                | Tags
                |--------------------------------------------------------------------------
                */

                this.tags =
                    (data.tags || []).map((id) => ({
                        key: this.generateKey(),
                        id: String(id),
                    }));


                /*
                |--------------------------------------------------------------------------
                | Includes
                |--------------------------------------------------------------------------
                */

                this.includes =
                    (data.includes || []).map((item) => ({
                        key:
                            this.generateKey(),

                        id:
                            item.id ?? '',

                        include_desc:
                            item.include_desc ?? '',
                    }));


                /*
                |--------------------------------------------------------------------------
                | Options
                |--------------------------------------------------------------------------
                */

                this.options =
                    (data.options || []).map((option) => ({
                        key:
                            this.generateKey(),

                        id:
                            option.id ?? '',

                        option_name:
                            option.option_name ?? '',

                        description:
                            option.description ?? '',

                        status: this.toBooleanStatus(option.status),

                        prices:
                            (option.prices || []).map((price) => ({
                                key:
                                    this.generateKey(),

                                id:
                                    price.id ?? '',

                                type:
                                    price.type ?? 'person',

                                label:
                                    price.label ?? '',

                                min:
                                    price.min ?? 1,

                                max:
                                    price.max ?? '',

                                price:
                                    price.price ?? '',
                            })),

                        times:
                            (option.times || []).map((time) => ({
                                key:
                                    this.generateKey(),

                                id:
                                    time.id ?? '',

                                time:
                                    time.time ?? '',
                            })),

                        addons:
                            (option.addons || []).map((addon) => ({
                                key:
                                    this.generateKey(),

                                id:
                                    addon.id ?? '',

                                addon_name:
                                    addon.addon_name ?? '',

                                description:
                                    addon.description ?? '',

                                price:
                                    addon.price ?? '',

                                min:
                                    addon.min ?? 0,

                                max:
                                    addon.max ?? 1,
                            })),
                    }));


                /*
                 * Create mode:
                 * minimal satu option.
                 */
                if (this.options.length === 0) {
                    this.addOption();
                }
            },


            /*
            |--------------------------------------------------------------------------
            | Helper
            |--------------------------------------------------------------------------
            */

            toBooleanStatus(value) {
                // Nilai dari Blade / old input dapat berupa boolean, angka, atau string.
                // Hanya null/undefined yang menggunakan default aktif.
                if (value === null || value === undefined || value === '') {
                    return true;
                }

                return value === true || value === 1 ||
                    (typeof value === 'string' &&
                     ['1', 'true', 'on', 'yes'].includes(value.trim().toLowerCase()));
            },

            generateKey() {
                return (
                    Date.now().toString(36) +
                    Math.random()
                        .toString(36)
                        .substring(2)
                );
            },


            /*
            |--------------------------------------------------------------------------
            | Tags
            |--------------------------------------------------------------------------
            */

            addTag() {
                this.tags.push({
                    key:
                        this.generateKey(),

                    id:
                        '',
                });
            },

            removeTag(index) {
                this.tags.splice(index, 1);
            },


            /*
            |--------------------------------------------------------------------------
            | Includes
            |--------------------------------------------------------------------------
            */

            addInclude() {
                this.includes.push({
                    key:
                        this.generateKey(),

                    id:
                        '',

                    include_desc:
                        '',
                });
            },

            removeInclude(index) {
                this.includes.splice(index, 1);
            },


            /*
            |--------------------------------------------------------------------------
            | Options
            |--------------------------------------------------------------------------
            */

            addOption() {
                const option = {
                    key:
                        this.generateKey(),

                    id:
                        '',

                    option_name:
                        '',

                    description:
                        '',

                    prices:
                        [],

                    times:
                        [],

                    addons:
                        [],
                    status:
                        true,
                };

                this.addPrice(option);

                this.options.push(option);
            },

            removeOption(index) {
                if (this.options.length <= 1) {
                    alert(
                        'Minimal harus memiliki satu travel option.'
                    );

                    return;
                }

                this.options.splice(index, 1);
            },


            /*
            |--------------------------------------------------------------------------
            | Prices
            |--------------------------------------------------------------------------
            */

            addPrice(option) {
                option.prices.push({
                    key:
                        this.generateKey(),

                    id:
                        '',

                    type:
                        'person',

                    label:
                        'Dewasa',

                    min:
                        1,

                    max:
                        '',

                    price:
                        '',
                });
            },

            removePrice(option, index) {
                if (option.prices.length <= 1) {
                    alert(
                        'Setiap option minimal memiliki satu harga.'
                    );

                    return;
                }

                option.prices.splice(index, 1);
            },


            /*
            |--------------------------------------------------------------------------
            | Times
            |--------------------------------------------------------------------------
            */

            addTime(option) {
                option.times.push({
                    key:
                        this.generateKey(),

                    id:
                        '',

                    time:
                        '',
                });
            },

            removeTime(option, index) {
                option.times.splice(index, 1);
            },


            /*
            |--------------------------------------------------------------------------
            | Addons
            |--------------------------------------------------------------------------
            */

            addAddon(option) {
                option.addons.push({
                    key:
                        this.generateKey(),

                    id:
                        '',

                    addon_name:
                        '',

                    description:
                        '',

                    price:
                        '',

                    min:
                        0,

                    max:
                        1,
                });
            },

            removeAddon(option, index) {
                option.addons.splice(index, 1);
            },
        };
    };


    /*
    |--------------------------------------------------------------------------
    | Image Preview
    |--------------------------------------------------------------------------
    */

    window.travelImage = function (
        initialImage = null
    ) {
        return {
            preview:
                initialImage,

            objectUrl:
                null,

            change(event) {
                const file =
                    event.target.files?.[0];

                if (!file) {
                    return;
                }

                if (this.objectUrl) {
                    URL.revokeObjectURL(
                        this.objectUrl
                    );
                }

                this.objectUrl =
                    URL.createObjectURL(file);

                this.preview =
                    this.objectUrl;
            },
        };
    };
</script>


@endpush
