<x-app-layout>

    <x-slot name="header">

        <div>

            <h2
                class="
                    font-semibold
                    text-xl
                    text-gray-800
                    dark:text-gray-200
                    leading-tight
                "
            >
                Edit Background
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Perbarui {{ $background->name }}.
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
                    overflow-hidden
                "
            >

                <form
                    action="{{ route('admin.backgrounds.update', $background->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf
                    @method('PUT')


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
                                Nama Background
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $background->name) }}"
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


                        {{-- CURRENT IMAGE --}}

                        @if ($background->image)

                            <div>

                                <label
                                    class="
                                        block
                                        mb-2
                                        text-sm
                                        font-medium
                                        text-gray-700
                                        dark:text-gray-300
                                    "
                                >
                                    Background Saat Ini
                                </label>

                                <img
                                    src="{{ asset('storage/' . $background->image) }}"
                                    alt="{{ $background->name }}"
                                    class="
                                        w-full
                                        max-w-xl
                                        h-64
                                        object-cover
                                        rounded-xl
                                        border
                                        border-gray-200
                                        dark:border-gray-700
                                    "
                                />

                            </div>

                        @endif


                        {{-- NEW IMAGE --}}

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
                                Ganti Background
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
                                Kosongkan jika tidak ingin mengganti background.
                                Maksimal 5 MB.
                            </p>

                            @error('image')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- SORT ORDER --}}

                        <div>

                            <label
                                for="sort_order"
                                class="
                                    block
                                    mb-2
                                    text-sm
                                    font-medium
                                    text-gray-700
                                    dark:text-gray-300
                                "
                            >
                                Urutan
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="sort_order"
                                type="number"
                                name="sort_order"
                                min="0"
                                value="{{ old('sort_order', $background->sort_order) }}"
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

                            <p
                                class="
                                    mt-2
                                    text-xs
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                Angka terkecil memiliki prioritas paling tinggi.
                            </p>

                            @error('sort_order')
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
                                    {{
                                        old(
                                            'status',
                                            $background->status
                                        )
                                            ? 'checked'
                                            : ''
                                    }}
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
                                        Background dapat ditampilkan pada halaman utama.
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
                            href="{{ route('admin.backgrounds.index') }}"
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
                                hover:bg-gray-50
                                dark:hover:bg-gray-700
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
