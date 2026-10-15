<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Cities
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola daftar kota yang tersedia di Travel Murah Jogja.
                </p>
            </div>

            <a
                href="{{ route('admin.cities.create') }}"
                class="
                    inline-flex
                    items-center
                    px-4
                    py-2
                    bg-blue-600
                    border
                    border-transparent
                    rounded-lg
                    font-semibold
                    text-xs
                    text-white
                    uppercase
                    tracking-widest
                    hover:bg-blue-700
                    focus:bg-blue-700
                    active:bg-blue-800
                    transition
                "
            >
                + Tambah City
            </a>

        </div>
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS MESSAGE --}}

            @if (session('success'))

                <div
                    class="
                        mb-6
                        px-4
                        py-3
                        rounded-lg
                        bg-green-100
                        text-green-800
                        dark:bg-green-900/30
                        dark:text-green-300
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            <div
                class="
                    bg-white
                    dark:bg-gray-800
                    overflow-hidden
                    shadow-sm
                    sm:rounded-lg
                "
            >

                <div class="p-6">

                    @if ($cities->count() > 0)

                        <div class="overflow-x-auto">

                            <table class="w-full">

                                <thead>

                                    <tr
                                        class="
                                            border-b
                                            border-gray-200
                                            dark:border-gray-700
                                        "
                                    >

                                        <th
                                            class="
                                                px-4
                                                py-3
                                                text-left
                                                text-xs
                                                font-semibold
                                                uppercase
                                                text-gray-500
                                                dark:text-gray-400
                                            "
                                        >
                                            Image
                                        </th>

                                        <th
                                            class="
                                                px-4
                                                py-3
                                                text-left
                                                text-xs
                                                font-semibold
                                                uppercase
                                                text-gray-500
                                                dark:text-gray-400
                                            "
                                        >
                                            City
                                        </th>

                                        <th
                                            class="
                                                px-4
                                                py-3
                                                text-left
                                                text-xs
                                                font-semibold
                                                uppercase
                                                text-gray-500
                                                dark:text-gray-400
                                            "
                                        >
                                            Slug
                                        </th>

                                        <th
                                            class="
                                                px-4
                                                py-3
                                                text-left
                                                text-xs
                                                font-semibold
                                                uppercase
                                                text-gray-500
                                                dark:text-gray-400
                                            "
                                        >
                                            Status
                                        </th>

                                        <th
                                            class="
                                                px-4
                                                py-3
                                                text-right
                                                text-xs
                                                font-semibold
                                                uppercase
                                                text-gray-500
                                                dark:text-gray-400
                                            "
                                        >
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody
                                    class="
                                        divide-y
                                        divide-gray-200
                                        dark:divide-gray-700
                                    "
                                >

                                    @foreach ($cities as $city)

                                        <tr
                                            class="
                                                hover:bg-gray-50
                                                dark:hover:bg-gray-700/40
                                                transition
                                            "
                                        >

                                            {{-- IMAGE --}}

                                            <td class="px-4 py-4">

                                                @if ($city->image)

                                                    <img
                                                        src="{{ asset('storage/' . $city->image) }}"
                                                        alt="{{ $city->name }}"
                                                        class="
                                                            w-20
                                                            h-14
                                                            rounded-lg
                                                            object-cover
                                                            border
                                                            border-gray-200
                                                            dark:border-gray-700
                                                        "
                                                    />

                                                @else

                                                    <div
                                                        class="
                                                            w-20
                                                            h-14
                                                            rounded-lg
                                                            bg-gray-100
                                                            dark:bg-gray-700
                                                            flex
                                                            items-center
                                                            justify-center
                                                            text-xs
                                                            text-gray-400
                                                        "
                                                    >
                                                        No Image
                                                    </div>

                                                @endif

                                            </td>


                                            {{-- NAME --}}

                                            <td class="px-4 py-4">

                                                <div
                                                    class="
                                                        font-semibold
                                                        text-gray-900
                                                        dark:text-gray-100
                                                    "
                                                >
                                                    {{ $city->name }}
                                                </div>

                                                @if ($city->description)

                                                    <div
                                                        class="
                                                            mt-1
                                                            max-w-md
                                                            truncate
                                                            text-sm
                                                            text-gray-500
                                                            dark:text-gray-400
                                                        "
                                                    >
                                                        {{ $city->description }}
                                                    </div>

                                                @endif

                                            </td>


                                            {{-- SLUG --}}

                                            <td
                                                class="
                                                    px-4
                                                    py-4
                                                    text-sm
                                                    text-gray-500
                                                    dark:text-gray-400
                                                "
                                            >
                                                {{ $city->slug }}
                                            </td>


                                            {{-- STATUS --}}

                                            <td class="px-4 py-4">

                                                @if ($city->status)

                                                    <span
                                                        class="
                                                            inline-flex
                                                            px-2.5
                                                            py-1
                                                            rounded-full
                                                            text-xs
                                                            font-semibold
                                                            bg-green-100
                                                            text-green-700
                                                            dark:bg-green-900/40
                                                            dark:text-green-300
                                                        "
                                                    >
                                                        Aktif
                                                    </span>

                                                @else

                                                    <span
                                                        class="
                                                            inline-flex
                                                            px-2.5
                                                            py-1
                                                            rounded-full
                                                            text-xs
                                                            font-semibold
                                                            bg-gray-100
                                                            text-gray-600
                                                            dark:bg-gray-700
                                                            dark:text-gray-300
                                                        "
                                                    >
                                                        Nonaktif
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- ACTION --}}

                                            <td class="px-4 py-4">

                                                <div
                                                    class="
                                                        flex
                                                        justify-end
                                                        items-center
                                                        gap-2
                                                    "
                                                >

                                                    <a
                                                        href="{{ route('admin.cities.edit', $city->id) }}"
                                                        class="
                                                            px-3
                                                            py-2
                                                            rounded-lg
                                                            text-sm
                                                            font-medium
                                                            text-blue-600
                                                            bg-blue-50
                                                            hover:bg-blue-100
                                                            dark:bg-blue-900/30
                                                            dark:text-blue-300
                                                            dark:hover:bg-blue-900/50
                                                            transition
                                                        "
                                                    >
                                                        Edit
                                                    </a>


                                                    <form
                                                        action="{{ route('admin.cities.destroy', $city->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus city {{ $city->name }}?')"
                                                    >

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="
                                                                px-3
                                                                py-2
                                                                rounded-lg
                                                                text-sm
                                                                font-medium
                                                                text-red-600
                                                                bg-red-50
                                                                hover:bg-red-100
                                                                dark:bg-red-900/30
                                                                dark:text-red-300
                                                                dark:hover:bg-red-900/50
                                                                transition
                                                            "
                                                        >
                                                            Hapus
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        {{-- EMPTY STATE --}}

                        <div class="py-16 text-center">

                            <h3
                                class="
                                    text-lg
                                    font-semibold
                                    text-gray-900
                                    dark:text-gray-100
                                "
                            >
                                Belum ada City
                            </h3>

                            <p
                                class="
                                    mt-2
                                    text-sm
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                Tambahkan kota pertama untuk mulai mengelola destinasi.
                            </p>

                            <a
                                href="{{ route('admin.cities.create') }}"
                                class="
                                    inline-flex
                                    mt-5
                                    px-4
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
                                Tambah City
                            </a>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
