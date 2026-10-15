<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Background
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola background yang ditampilkan pada halaman utama.
                </p>
            </div>

            <a
                href="{{ route('admin.backgrounds.create') }}"
                class="
                    px-4 py-2
                    rounded-lg
                    bg-blue-600
                    text-white
                    text-sm
                    font-semibold
                    hover:bg-blue-700
                    transition
                "
            >
                + Tambah Background
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
                        px-4 py-3
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


            {{-- INFO --}}

            <div
                class="
                    mb-6
                    px-4 py-3
                    rounded-lg
                    bg-blue-50
                    text-blue-700
                    dark:bg-blue-900/20
                    dark:text-blue-300
                    text-sm
                "
            >
                Maksimal 3 background aktif dengan urutan teratas
                akan ditampilkan pada halaman utama.
            </div>


            <div
                class="
                    bg-white
                    dark:bg-gray-800
                    overflow-hidden
                    shadow-sm
                    sm:rounded-lg
                "
            >

                @if ($backgrounds->count() > 0)

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

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Preview
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Nama
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                        Urutan
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-gray-500">
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

                                @foreach ($backgrounds as $background)

                                    <tr
                                        class="
                                            hover:bg-gray-50
                                            dark:hover:bg-gray-700/40
                                            transition
                                        "
                                    >

                                        {{-- IMAGE --}}

                                        <td class="px-6 py-4">

                                            @if ($background->image)

                                                <img
                                                    src="{{ asset('storage/' . $background->image) }}"
                                                    alt="{{ $background->name }}"
                                                    class="
                                                        w-40
                                                        h-24
                                                        object-cover
                                                        rounded-lg
                                                        border
                                                        border-gray-200
                                                        dark:border-gray-700
                                                    "
                                                />

                                            @else

                                                <div
                                                    class="
                                                        w-40
                                                        h-24
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

                                        <td class="px-6 py-4">

                                            <div
                                                class="
                                                    font-semibold
                                                    text-gray-900
                                                    dark:text-gray-100
                                                "
                                            >
                                                {{ $background->name }}
                                            </div>

                                            <div
                                                class="
                                                    mt-1
                                                    text-xs
                                                    text-gray-500
                                                    dark:text-gray-400
                                                "
                                            >
                                                Background Homepage
                                            </div>

                                        </td>


                                        {{-- ORDER --}}

                                        <td class="px-6 py-4 text-center">

                                            <span
                                                class="
                                                    inline-flex
                                                    items-center
                                                    justify-center
                                                    w-8
                                                    h-8
                                                    rounded-full
                                                    bg-gray-100
                                                    dark:bg-gray-700
                                                    text-sm
                                                    font-semibold
                                                    text-gray-700
                                                    dark:text-gray-200
                                                "
                                            >
                                                {{ $background->sort_order }}
                                            </span>

                                        </td>


                                        {{-- STATUS --}}

                                        <td class="px-6 py-4">

                                            <div class="flex justify-center">

                                                <form
                                                    action="{{ route('admin.backgrounds.status', $background->id) }}"
                                                    method="POST"
                                                >

                                                    @csrf
                                                    @method('PATCH')

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="{{ $background->status ? 0 : 1 }}"
                                                    />

                                                    <button
                                                        type="submit"
                                                        class="
                                                            relative
                                                            inline-flex
                                                            h-6
                                                            w-11
                                                            items-center
                                                            rounded-full
                                                            transition
                                                            {{ $background->status
                                                                ? 'bg-blue-600'
                                                                : 'bg-gray-300 dark:bg-gray-600'
                                                            }}
                                                        "
                                                        title="{{ $background->status ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                    >

                                                        <span
                                                            class="
                                                                inline-block
                                                                h-4
                                                                w-4
                                                                transform
                                                                rounded-full
                                                                bg-white
                                                                transition
                                                                {{ $background->status
                                                                    ? 'translate-x-6'
                                                                    : 'translate-x-1'
                                                                }}
                                                            "
                                                        ></span>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>


                                        {{-- ACTION --}}

                                        <td class="px-6 py-4">

                                            <div
                                                class="
                                                    flex
                                                    justify-end
                                                    items-center
                                                    gap-2
                                                "
                                            >

                                                <a
                                                    href="{{ route('admin.backgrounds.edit', $background->id) }}"
                                                    class="
                                                        px-3 py-2
                                                        rounded-lg
                                                        text-sm
                                                        font-medium
                                                        text-blue-600
                                                        bg-blue-50
                                                        hover:bg-blue-100
                                                        dark:bg-blue-900/30
                                                        dark:text-blue-300
                                                    "
                                                >
                                                    Edit
                                                </a>


                                                <form
                                                    action="{{ route('admin.backgrounds.destroy', $background->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus background ini?')"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="
                                                            px-3 py-2
                                                            rounded-lg
                                                            text-sm
                                                            font-medium
                                                            text-red-600
                                                            bg-red-50
                                                            hover:bg-red-100
                                                            dark:bg-red-900/30
                                                            dark:text-red-300
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
                            Belum ada Background
                        </h3>

                        <p
                            class="
                                mt-2
                                text-sm
                                text-gray-500
                                dark:text-gray-400
                            "
                        >
                            Tambahkan background untuk ditampilkan pada halaman utama.
                        </p>

                        <a
                            href="{{ route('admin.backgrounds.create') }}"
                            class="
                                inline-flex
                                mt-5
                                px-4 py-2
                                rounded-lg
                                bg-blue-600
                                text-white
                                text-sm
                                font-semibold
                                hover:bg-blue-700
                            "
                        >
                            Tambah Background
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
