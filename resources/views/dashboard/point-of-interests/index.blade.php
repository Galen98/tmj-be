<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Point of Interest
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola destinasi dan kawasan wisata.
                </p>

            </div>

            <a
                href="{{ route('admin.point-of-interests.create') }}"
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
                + Tambah Point of Interest
            </a>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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


            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="p-6">

                    @if ($pointOfInterests->count() > 0)

                        <div class="overflow-x-auto">

                            <table class="w-full">

                                <thead>

                                    <tr class="border-b border-gray-200 dark:border-gray-700">

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                            Image
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                            Point of Interest
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                            City
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                            Status
                                        </th>

                                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                    @foreach ($pointOfInterests as $pointOfInterest)

                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">

                                            <td class="px-4 py-4">

                                                @if ($pointOfInterest->image)

                                                    <img
                                                        src="{{ asset('storage/' . $pointOfInterest->image) }}"
                                                        class="w-20 h-14 object-cover rounded-lg"
                                                        alt="{{ $pointOfInterest->name }}"
                                                    />

                                                @else

                                                    <div
                                                        class="
                                                            w-20 h-14
                                                            bg-gray-100
                                                            dark:bg-gray-700
                                                            rounded-lg
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


                                            <td class="px-4 py-4">

                                                <div class="font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $pointOfInterest->name }}
                                                </div>

                                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $pointOfInterest->slug }}
                                                </div>

                                            </td>


                                            <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">

                                                {{ $pointOfInterest->city?->name ?? '-' }}

                                            </td>


                                            <td class="px-4 py-4">

                                                @if ($pointOfInterest->status)

                                                    <span
                                                        class="
                                                            px-2.5 py-1
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
                                                            px-2.5 py-1
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


                                            <td class="px-4 py-4">

                                                <div class="flex justify-end gap-2">

                                                    <a
                                                        href="{{ route('admin.point-of-interests.edit', $pointOfInterest->id) }}"
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
                                                        method="POST"
                                                        action="{{ route('admin.point-of-interests.destroy', $pointOfInterest->id) }}"
                                                        onsubmit="return confirm('Yakin ingin menghapus {{ $pointOfInterest->name }}?')"
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

                        <div class="py-16 text-center">

                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Belum ada Point of Interest
                            </h3>

                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Tambahkan destinasi wisata pertama.
                            </p>

                            <a
                                href="{{ route('admin.point-of-interests.create') }}"
                                class="
                                    inline-flex
                                    mt-5
                                    px-4 py-2
                                    rounded-lg
                                    bg-blue-600
                                    text-white
                                    text-sm
                                    font-semibold
                                "
                            >
                                Tambah Point of Interest
                            </a>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
