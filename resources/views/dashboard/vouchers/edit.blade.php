<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Voucher
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Perbarui {{ $voucher->voucher_name }}.
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
                    action="{{ route('admin.vouchers.update', $voucher->id) }}"
                    method="POST"
                >

                    @csrf
                    @method('PUT')


                    <div class="p-6 space-y-6">


                        {{-- NAME + CODE --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Voucher
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="voucher_name"
                                    value="{{ old('voucher_name', $voucher->voucher_name) }}"
                                    class="
                                        w-full rounded-lg
                                        border-gray-300
                                        dark:border-gray-700
                                        dark:bg-gray-900
                                        dark:text-gray-100
                                        focus:border-blue-500
                                        focus:ring-blue-500
                                    "
                                />

                                @error('voucher_name')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kode Voucher
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="voucher_code"
                                    value="{{ old('voucher_code', $voucher->voucher_code) }}"
                                    class="
                                        w-full rounded-lg
                                        uppercase
                                        border-gray-300
                                        dark:border-gray-700
                                        dark:bg-gray-900
                                        dark:text-gray-100
                                        focus:border-blue-500
                                        focus:ring-blue-500
                                    "
                                />

                                @error('voucher_code')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>


                        {{-- EXPIRED --}}

                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Berlaku Sampai
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="datetime-local"
                                name="voucher_expired"
                                value="{{ old(
                                    'voucher_expired',
                                    $voucher->voucher_expired->format('Y-m-d\TH:i')
                                ) }}"
                                class="
                                    w-full rounded-lg
                                    border-gray-300
                                    dark:border-gray-700
                                    dark:bg-gray-900
                                    dark:text-gray-100
                                    focus:border-blue-500
                                    focus:ring-blue-500
                                "
                            />

                            @error('voucher_expired')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- QUOTA / CLAIM --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kuota
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="number"
                                    name="quota"
                                    min="{{ $voucher->claim }}"
                                    value="{{ old('quota', $voucher->quota) }}"
                                    class="
                                        w-full rounded-lg
                                        border-gray-300
                                        dark:border-gray-700
                                        dark:bg-gray-900
                                        dark:text-gray-100
                                        focus:border-blue-500
                                        focus:ring-blue-500
                                    "
                                />

                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Kuota tidak boleh lebih kecil dari jumlah voucher yang sudah digunakan.
                                </p>

                                @error('quota')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Sudah Digunakan
                                </label>

                                <input
                                    type="number"
                                    value="{{ $voucher->claim }}"
                                    disabled
                                    class="
                                        w-full rounded-lg
                                        border-gray-300
                                        bg-gray-100
                                        text-gray-500
                                        dark:border-gray-700
                                        dark:bg-gray-700
                                        dark:text-gray-400
                                    "
                                />

                                {{-- tetap kirim claim karena UpdateRequest kita saat ini membutuhkannya --}}
                                <input
                                    type="hidden"
                                    name="claim"
                                    value="{{ $voucher->claim }}"
                                />

                            </div>

                        </div>


                        {{-- DISCOUNT TYPE --}}

                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tipe Diskon
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                name="discount_type"
                                class="
                                    w-full rounded-lg
                                    border-gray-300
                                    dark:border-gray-700
                                    dark:bg-gray-900
                                    dark:text-gray-100
                                    focus:border-blue-500
                                    focus:ring-blue-500
                                "
                            >

                                <option
                                    value="percentage"
                                    {{
                                        old(
                                            'discount_type',
                                            $voucher->discount_type
                                        ) === 'percentage'
                                            ? 'selected'
                                            : ''
                                    }}
                                >
                                    Persentase (%)
                                </option>

                                <option
                                    value="fixed"
                                    {{
                                        old(
                                            'discount_type',
                                            $voucher->discount_type
                                        ) === 'fixed'
                                            ? 'selected'
                                            : ''
                                    }}
                                >
                                    Nominal (Rp)
                                </option>

                            </select>

                            @error('discount_type')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- DISCOUNT VALUE + MAX --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nilai Diskon
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="discount_value"
                                    value="{{ old('discount_value', $voucher->discount_value) }}"
                                    class="
                                        w-full rounded-lg
                                        border-gray-300
                                        dark:border-gray-700
                                        dark:bg-gray-900
                                        dark:text-gray-100
                                        focus:border-blue-500
                                        focus:ring-blue-500
                                    "
                                />

                                @error('discount_value')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Maksimal Diskon
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="max_discount"
                                    value="{{ old('max_discount', $voucher->max_discount) }}"
                                    placeholder="Contoh: 100000"
                                    class="
                                        w-full rounded-lg
                                        border-gray-300
                                        dark:border-gray-700
                                        dark:bg-gray-900
                                        dark:text-gray-100
                                        focus:border-blue-500
                                        focus:ring-blue-500
                                    "
                                />

                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Digunakan untuk membatasi diskon persentase.
                                </p>

                                @error('max_discount')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>


                        {{-- MIN TRANSACTION --}}

                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Minimum Transaksi
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="min_transaction"
                                value="{{ old('min_transaction', $voucher->min_transaction) }}"
                                class="
                                    w-full rounded-lg
                                    border-gray-300
                                    dark:border-gray-700
                                    dark:bg-gray-900
                                    dark:text-gray-100
                                    focus:border-blue-500
                                    focus:ring-blue-500
                                "
                            />

                            @error('min_transaction')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- SETTINGS --}}

                        <div
                            class="
                                border-t
                                border-gray-200
                                dark:border-gray-700
                                pt-6
                            "
                        >

                            <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                                Pengaturan Voucher
                            </h3>


                            <div class="mt-4 space-y-4">

                                <label class="flex items-center gap-3 cursor-pointer">

                                    <input
                                        type="checkbox"
                                        name="is_visible"
                                        value="1"
                                        {{
                                            old(
                                                'is_visible',
                                                $voucher->is_visible
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
                                            Tampilkan Voucher
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Voucher ditampilkan kepada pengguna di website.
                                        </div>

                                    </div>

                                </label>


                                <label class="flex items-center gap-3 cursor-pointer">

                                    <input
                                        type="checkbox"
                                        name="status"
                                        value="1"
                                        {{
                                            old(
                                                'status',
                                                $voucher->status
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
                                            Voucher Aktif
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Voucher dapat digunakan untuk transaksi.
                                        </div>

                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>


                    {{-- FOOTER --}}

                    <div
                        class="
                            flex items-center justify-end gap-3
                            px-6 py-4
                            border-t
                            border-gray-200
                            dark:border-gray-700
                        "
                    >

                        <a
                            href="{{ route('admin.vouchers.index') }}"
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
