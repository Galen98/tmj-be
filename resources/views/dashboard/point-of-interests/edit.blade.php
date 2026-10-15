<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Point of Interest
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Perbarui informasi {{ $pointOfInterest->name }}.
            </p>
        </div>
    </x-slot>


    <div class="py-12">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <form
                    action="{{ route('admin.point-of-interests.update', $pointOfInterest->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf
                    @method('PUT')


                    <div class="p-6 space-y-6">

                        {{-- CITY --}}

                        <div>

                            <label
                                for="city_id"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                City
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="city_id"
                                name="city_id"
                                class="
                                    w-full
                                    rounded-lg
                                    border-gray-300
                                    dark:border-gray-700
                                    dark:bg-gray-900
                                    dark:text-gray-100
                                    focus:border-blue-500
                                    focus:ring-blue-500
                                "
                            >

                                <option value="">
                                    Pilih City
                                </option>

                                @foreach ($cities as $city)

                                    <option
                                        value="{{ $city->id }}"
                                        {{
                                            old(
                                                'city_id',
                                                $pointOfInterest->city_id
                                            ) == $city->id
                                                ? 'selected'
                                                : ''
                                        }}
                                    >
                                        {{ $city->name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('city_id')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- NAME --}}

                        <div>

                            <label
                                for="name"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Nama Point of Interest
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $pointOfInterest->name) }}"
                                class="
                                    w-full
                                    rounded-lg
                                    border-gray-300
                                    dark:border-gray-700
                                    dark:bg-gray-900
                                    dark:text-gray-100
                                    focus:border-blue-500
                                    focus:ring-blue-500
                                "
                            />

                            @error('name')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- SLUG --}}

                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Slug
                            </label>

                            <div
                                class="
                                    px-4
                                    py-2.5
                                    rounded-lg
                                    bg-gray-100
                                    dark:bg-gray-900
                                    text-sm
                                    text-gray-600
                                    dark:text-gray-400
                                "
                            >
                                {{ $pointOfInterest->slug }}
                            </div>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Slug dibuat otomatis berdasarkan nama Point of Interest.
                            </p>

                        </div>


                        {{-- DESCRIPTION --}}

                        <div>

                            <label
                                for="description"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Deskripsi
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                class="
                                    w-full
                                    rounded-lg
                                    border-gray-300
                                    dark:border-gray-700
                                    dark:bg-gray-900
                                    dark:text-gray-100
                                    focus:border-blue-500
                                    focus:ring-blue-500
                                "
                            >{{ old('description', $pointOfInterest->description) }}</textarea>

                            @error('description')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- CURRENT IMAGE --}}

                        @if ($pointOfInterest->image)

                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Gambar Saat Ini
                                </label>

                                <img
                                    src="{{ asset('storage/' . $pointOfInterest->image) }}"
                                    alt="{{ $pointOfInterest->name }}"
                                    class="
                                        w-64
                                        h-40
                                        rounded-xl
                                        object-cover
                                        border
                                        border-gray-200
                                        dark:border-gray-700
                                    "
                                />

                            </div>

                        @endif


                        {{-- IMAGE --}}

                        <div>

                            <label
                                for="image"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Ganti Gambar
                            </label>

                            <input
                                id="image"
                                type="file"
                                name="image"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="
                                    block
                                    w-full
                                    text-sm
                                    text-gray-500
                                    dark:text-gray-400
                                    file:me-4
                                    file:py-2
                                    file:px-4
                                    file:rounded-lg
                                    file:border-0
                                    file:text-sm
                                    file:font-semibold
                                    file:bg-blue-50
                                    file:text-blue-700
                                    hover:file:bg-blue-100
                                    dark:file:bg-blue-900/30
                                    dark:file:text-blue-300
                                "
                            />

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Kosongkan jika tidak ingin mengganti gambar.
                            </p>

                            @error('image')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- STATUS --}}

                        <div>

                            <label class="flex items-center gap-3 cursor-pointer">

                                <input
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    {{
                                        old(
                                            'status',
                                            $pointOfInterest->status
                                        )
                                            ? 'checked'
                                            : ''
                                    }}
                                    class="
                                        rounded
                                        border-gray-300
                                        text-blue-600
                                        focus:ring-blue-500
                                    "
                                />

                                <div>

                                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Aktif
                                    </div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Point of Interest dapat ditampilkan pada website.
                                    </div>

                                </div>

                            </label>

                        </div>

                    </div>


                    <div
                        class="
                            flex
                            justify-end
                            gap-3
                            px-6
                            py-4
                            border-t
                            border-gray-200
                            dark:border-gray-700
                        "
                    >

                        <a
                            href="{{ route('admin.point-of-interests.index') }}"
                            class="
                                px-4 py-2
                                rounded-lg
                                border
                                border-gray-300
                                dark:border-gray-600
                                text-sm
                                font-semibold
                                text-gray-700
                                dark:text-gray-300
                            "
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="
                                px-5 py-2
                                rounded-lg
                                bg-blue-600
                                text-white
                                text-sm
                                font-semibold
                                hover:bg-blue-700
                            "
                        >
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
