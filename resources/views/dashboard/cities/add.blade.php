<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tambah City
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Tambahkan kota baru untuk destinasi Travel Murah Jogja.
            </p>
        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div
                class="
                    bg-white
                    dark:bg-gray-800
                    shadow-sm
                    sm:rounded-lg
                "
            >

                <form
                    action="{{ route('admin.cities.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf


                    <div class="p-6 space-y-6">


                        {{-- NAME --}}

                        <div>

                            <label
                                for="name"
                                class="
                                    block
                                    mb-2
                                    text-sm
                                    font-medium
                                    text-gray-700
                                    dark:text-gray-300
                                "
                            >
                                Nama City
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Contoh: Yogyakarta"
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


                        {{-- DESCRIPTION --}}

                        <div>

                            <label
                                for="description"
                                class="
                                    block
                                    mb-2
                                    text-sm
                                    font-medium
                                    text-gray-700
                                    dark:text-gray-300
                                "
                            >
                                Deskripsi
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Contoh: Nikmati berbagai pengalaman wisata di Yogyakarta."
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
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- IMAGE --}}

                        <div>

                            <label
                                for="image"
                                class="
                                    block
                                    mb-2
                                    text-sm
                                    font-medium
                                    text-gray-700
                                    dark:text-gray-300
                                "
                            >
                                Gambar City
                                <span class="text-red-500">*</span>
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

                            <p
                                class="
                                    mt-2
                                    text-xs
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                Format JPG, JPEG, PNG atau WEBP. Maksimal 2 MB.
                            </p>

                            @error('image')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- STATUS --}}

                        <div>

                            <label
                                class="
                                    flex
                                    items-center
                                    gap-3
                                    cursor-pointer
                                "
                            >

                                <input
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    {{ old('status', true) ? 'checked' : '' }}
                                    class="
                                        rounded
                                        border-gray-300
                                        text-blue-600
                                        shadow-sm
                                        focus:ring-blue-500
                                    "
                                />

                                <div>

                                    <div
                                        class="
                                            text-sm
                                            font-medium
                                            text-gray-700
                                            dark:text-gray-300
                                        "
                                    >
                                        Aktif
                                    </div>

                                    <div
                                        class="
                                            text-xs
                                            text-gray-500
                                            dark:text-gray-400
                                        "
                                    >
                                        City aktif dapat ditampilkan pada website.
                                    </div>

                                </div>

                            </label>

                        </div>

                    </div>


                    {{-- FOOTER --}}

                    <div
                        class="
                            flex
                            items-center
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
                            href="{{ route('admin.cities.index') }}"
                            class="
                                px-4
                                py-2
                                rounded-lg
                                border
                                border-gray-300
                                dark:border-gray-600
                                text-sm
                                font-semibold
                                text-gray-700
                                dark:text-gray-300
                                hover:bg-gray-50
                                dark:hover:bg-gray-700
                                transition
                            "
                        >
                            Batal
                        </a>


                        <button
                            type="submit"
                            class="
                                px-5
                                py-2
                                rounded-lg
                                bg-blue-600
                                text-white
                                text-sm
                                font-semibold
                                hover:bg-blue-700
                                transition
                            "
                        >
                            Simpan City
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
