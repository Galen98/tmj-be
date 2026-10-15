<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Voucher
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola voucher dan promo Travel Murah Jogja.
                </p>
            </div>

            <a
                href="{{ route('admin.vouchers.create') }}"
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
                + Tambah Voucher
            </a>

        </div>
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS --}}

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


            <div
                class="
                    bg-white
                    dark:bg-gray-800
                    overflow-hidden
                    shadow-sm
                    sm:rounded-lg
                "
            >

                @if ($vouchers->count() > 0)

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

                                    <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Voucher
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Diskon
                                    </th>

                                    <th class="px-5 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                        Penggunaan
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Kadaluarsa
                                    </th>

                                    <th class="px-5 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                        Visible
                                    </th>

                                    <th class="px-5 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                        Status
                                    </th>

                                    <th class="px-5 py-4 text-right text-xs font-semibold uppercase text-gray-500">
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

                                @foreach ($vouchers as $voucher)

                                    @php

                                        $isExpired =
                                            $voucher->voucher_expired->isPast();

                                        $isQuotaEmpty =
                                            $voucher->claim >= $voucher->quota;

                                    @endphp


                                    <tr
                                        class="
                                            hover:bg-gray-50
                                            dark:hover:bg-gray-700/40
                                            transition
                                        "
                                    >

                                        {{-- VOUCHER --}}

                                        <td class="px-5 py-4">

                                            <div
                                                class="
                                                    font-semibold
                                                    text-gray-900
                                                    dark:text-gray-100
                                                "
                                            >
                                                {{ $voucher->voucher_name }}
                                            </div>

                                            <div class="mt-1">

                                                <span
                                                    class="
                                                        inline-flex
                                                        rounded-md
                                                        bg-gray-100
                                                        dark:bg-gray-700
                                                        px-2 py-1
                                                        font-mono
                                                        text-xs
                                                        font-semibold
                                                        text-gray-700
                                                        dark:text-gray-200
                                                    "
                                                >
                                                    {{ $voucher->voucher_code }}
                                                </span>

                                            </div>

                                        </td>


                                        {{-- DISCOUNT --}}

                                        <td class="px-5 py-4">

                                            <div
                                                class="
                                                    font-semibold
                                                    text-gray-900
                                                    dark:text-gray-100
                                                "
                                            >

                                                @if ($voucher->discount_type === 'percentage')

                                                    {{ rtrim(rtrim(number_format($voucher->discount_value, 2, '.', ''), '0'), '.') }}%

                                                @else

                                                    Rp{{ number_format($voucher->discount_value, 0, ',', '.') }}

                                                @endif

                                            </div>


                                            @if (
                                                $voucher->discount_type === 'percentage'
                                                && $voucher->max_discount
                                            )

                                                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                    Maks.
                                                    Rp{{ number_format($voucher->max_discount, 0, ',', '.') }}
                                                </div>

                                            @endif


                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">

                                                Min.
                                                Rp{{ number_format($voucher->min_transaction, 0, ',', '.') }}

                                            </div>

                                        </td>


                                        {{-- QUOTA --}}

                                        <td class="px-5 py-4 text-center">

                                            <div
                                                class="
                                                    font-semibold
                                                    {{ $isQuotaEmpty
                                                        ? 'text-red-600 dark:text-red-400'
                                                        : 'text-gray-900 dark:text-gray-100'
                                                    }}
                                                "
                                            >
                                                {{ $voucher->claim }}
                                                /
                                                {{ $voucher->quota }}
                                            </div>

                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                Sisa
                                                {{ max(0, $voucher->quota - $voucher->claim) }}
                                            </div>

                                        </td>


                                        {{-- EXPIRED --}}

                                        <td class="px-5 py-4">

                                            <div
                                                class="
                                                    text-sm
                                                    {{ $isExpired
                                                        ? 'text-red-600 dark:text-red-400'
                                                        : 'text-gray-700 dark:text-gray-300'
                                                    }}
                                                "
                                            >
                                                {{ $voucher->voucher_expired->format('d M Y H:i') }}
                                            </div>


                                            @if ($isExpired)

                                                <span
                                                    class="
                                                        inline-flex
                                                        mt-1
                                                        px-2 py-1
                                                        rounded-full
                                                        bg-red-100
                                                        text-red-700
                                                        dark:bg-red-900/30
                                                        dark:text-red-300
                                                        text-xs
                                                        font-medium
                                                    "
                                                >
                                                    Kadaluarsa
                                                </span>

                                            @endif

                                        </td>


                                        {{-- VISIBLE --}}

                                        <td class="px-5 py-4 text-center">

                                            @if ($voucher->is_visible)

                                                <span
                                                    class="
                                                        inline-flex
                                                        px-2 py-1
                                                        rounded-full
                                                        bg-green-100
                                                        text-green-700
                                                        dark:bg-green-900/30
                                                        dark:text-green-300
                                                        text-xs
                                                        font-semibold
                                                    "
                                                >
                                                    Visible
                                                </span>

                                            @else

                                                <span
                                                    class="
                                                        inline-flex
                                                        px-2 py-1
                                                        rounded-full
                                                        bg-gray-100
                                                        text-gray-600
                                                        dark:bg-gray-700
                                                        dark:text-gray-300
                                                        text-xs
                                                        font-semibold
                                                    "
                                                >
                                                    Hidden
                                                </span>

                                            @endif

                                        </td>


                                        {{-- STATUS --}}

                                        <td class="px-5 py-4 text-center">

                                            @if ($voucher->status)

                                                <span
                                                    class="
                                                        inline-flex
                                                        px-2 py-1
                                                        rounded-full
                                                        bg-blue-100
                                                        text-blue-700
                                                        dark:bg-blue-900/30
                                                        dark:text-blue-300
                                                        text-xs
                                                        font-semibold
                                                    "
                                                >
                                                    Aktif
                                                </span>

                                            @else

                                                <span
                                                    class="
                                                        inline-flex
                                                        px-2 py-1
                                                        rounded-full
                                                        bg-gray-100
                                                        text-gray-600
                                                        dark:bg-gray-700
                                                        dark:text-gray-300
                                                        text-xs
                                                        font-semibold
                                                    "
                                                >
                                                    Nonaktif
                                                </span>

                                            @endif

                                        </td>


                                        {{-- ACTION --}}

                                        <td class="px-5 py-4">

                                            <div class="flex justify-end items-center gap-2">

                                                <a
                                                    href="{{ route('admin.vouchers.edit', $voucher->id) }}"
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
                                                    action="{{ route('admin.vouchers.destroy', $voucher->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus voucher ini?')"
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
                            Belum ada Voucher
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Tambahkan voucher untuk memberikan promo kepada pelanggan.
                        </p>

                        <a
                            href="{{ route('admin.vouchers.create') }}"
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
                            Tambah Voucher
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
