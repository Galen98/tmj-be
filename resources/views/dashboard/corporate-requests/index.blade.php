<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Pengajuan Korporasi
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Daftar permintaan paket perjalanan korporasi dari customer.
                </p>

            </div>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="
                    bg-white
                    dark:bg-gray-800
                    overflow-hidden
                    shadow-sm
                    sm:rounded-lg
                "
            >

                @if ($corporateRequests->count() > 0)

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
                                            px-6 py-4
                                            text-left
                                            text-xs
                                            font-semibold
                                            uppercase
                                            text-gray-500
                                        "
                                    >
                                        Perusahaan
                                    </th>

                                    <th
                                        class="
                                            px-6 py-4
                                            text-left
                                            text-xs
                                            font-semibold
                                            uppercase
                                            text-gray-500
                                        "
                                    >
                                        WhatsApp
                                    </th>

                                    <th
                                        class="
                                            px-6 py-4
                                            text-left
                                            text-xs
                                            font-semibold
                                            uppercase
                                            text-gray-500
                                        "
                                    >
                                        Email
                                    </th>

                                    <th
                                        class="
                                            px-6 py-4
                                            text-center
                                            text-xs
                                            font-semibold
                                            uppercase
                                            text-gray-500
                                        "
                                    >
                                        Durasi
                                    </th>

                                    <th
                                        class="
                                            px-6 py-4
                                            text-center
                                            text-xs
                                            font-semibold
                                            uppercase
                                            text-gray-500
                                        "
                                    >
                                        Peserta
                                    </th>

                                    <th
                                        class="
                                            px-6 py-4
                                            text-left
                                            text-xs
                                            font-semibold
                                            uppercase
                                            text-gray-500
                                        "
                                    >
                                        Tanggal
                                    </th>

                                    <th
                                        class="
                                            px-6 py-4
                                            text-right
                                            text-xs
                                            font-semibold
                                            uppercase
                                            text-gray-500
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

                                @foreach ($corporateRequests as $item)

                                    <tr
                                        class="
                                            hover:bg-gray-50
                                            dark:hover:bg-gray-700/40
                                            transition
                                        "
                                    >

                                        {{-- COMPANY --}}

                                        <td class="px-6 py-4">

                                            <div
                                                class="
                                                    font-semibold
                                                    text-gray-900
                                                    dark:text-gray-100
                                                "
                                            >
                                                {{ $item->company_name }}
                                            </div>

                                        </td>


                                        {{-- WHATSAPP --}}

                                        <td
                                            class="
                                                px-6 py-4
                                                text-sm
                                                text-gray-700
                                                dark:text-gray-300
                                            "
                                        >
                                            {{ $item->whatsapp }}
                                        </td>


                                        {{-- EMAIL --}}

                                        <td
                                            class="
                                                px-6 py-4
                                                text-sm
                                                text-gray-700
                                                dark:text-gray-300
                                            "
                                        >
                                            {{ $item->email }}
                                        </td>


                                        {{-- DURATION --}}

                                        <td class="px-6 py-4 text-center">

                                            <span
                                                class="
                                                    inline-flex
                                                    px-3 py-1
                                                    rounded-full
                                                    bg-blue-50
                                                    text-blue-700
                                                    dark:bg-blue-900/30
                                                    dark:text-blue-300
                                                    text-xs
                                                    font-semibold
                                                "
                                            >
                                                {{ $item->duration_days }} Hari
                                            </span>

                                        </td>


                                        {{-- PARTICIPANT --}}

                                        <td
                                            class="
                                                px-6 py-4
                                                text-center
                                                text-sm
                                                text-gray-700
                                                dark:text-gray-300
                                            "
                                        >
                                            {{ $item->participant_count }} Orang
                                        </td>


                                        {{-- CREATED DATE --}}

                                        <td
                                            class="
                                                px-6 py-4
                                                text-sm
                                                text-gray-500
                                                dark:text-gray-400
                                            "
                                        >
                                            {{ $item->created_at->format('d M Y H:i') }}
                                        </td>


                                        {{-- ACTION --}}

                                        <td class="px-6 py-4">

                                            <div
                                                class="
                                                    flex
                                                    justify-end
                                                    items-center
                                                "
                                            >

                                                <a
                                                    href="{{
                                                        route(
                                                            'admin.corporate-requests.show',
                                                            $item->id
                                                        )
                                                    }}"
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
                                                        transition
                                                    "
                                                >
                                                    Lihat
                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- PAGINATION --}}

                    @if ($corporateRequests->hasPages())

                        <div
                            class="
                                px-6 py-4
                                border-t
                                border-gray-200
                                dark:border-gray-700
                            "
                        >
                            {{ $corporateRequests->links() }}
                        </div>

                    @endif

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
                            Belum ada Pengajuan Korporasi
                        </h3>

                        <p
                            class="
                                mt-2
                                text-sm
                                text-gray-500
                                dark:text-gray-400
                            "
                        >
                            Pengajuan paket korporasi dari customer
                            akan ditampilkan di halaman ini.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
