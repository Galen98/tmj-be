<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

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
                    Detail Pengajuan Korporasi
                </h2>

                <p
                    class="
                        mt-1
                        text-sm
                        text-gray-500
                        dark:text-gray-400
                    "
                >
                    Informasi lengkap permintaan paket korporasi customer.
                </p>

            </div>


            <a
                href="{{ route('admin.corporate-requests.index') }}"
                class="
                    px-4 py-2
                    rounded-lg
                    bg-gray-100
                    text-gray-700
                    text-sm
                    font-semibold
                    hover:bg-gray-200
                    dark:bg-gray-700
                    dark:text-gray-200
                    dark:hover:bg-gray-600
                    transition
                "
            >
                Kembali
            </a>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div
                class="
                    bg-white
                    dark:bg-gray-800
                    overflow-hidden
                    shadow-sm
                    sm:rounded-lg
                "
            >

                {{-- HEADER CUSTOMER --}}

                <div
                    class="
                        px-6 py-5
                        border-b
                        border-gray-200
                        dark:border-gray-700
                    "
                >

                    <h3
                        class="
                            text-lg
                            font-semibold
                            text-gray-900
                            dark:text-gray-100
                        "
                    >
                        {{ $corporateRequest->company_name }}
                    </h3>

                    <p
                        class="
                            mt-1
                            text-sm
                            text-gray-500
                            dark:text-gray-400
                        "
                    >
                        Dikirim pada
                        {{ $corporateRequest->created_at->format('d M Y H:i') }}
                    </p>

                </div>


                {{-- CONTACT INFORMATION --}}

                <div class="px-6 py-6">

                    <h4
                        class="
                            mb-5
                            text-sm
                            font-semibold
                            uppercase
                            tracking-wide
                            text-gray-500
                            dark:text-gray-400
                        "
                    >
                        Informasi Kontak
                    </h4>


                    <div
                        class="
                            grid
                            grid-cols-1
                            md:grid-cols-2
                            gap-6
                        "
                    >

                        {{-- WHATSAPP --}}

                        <div>

                            <div
                                class="
                                    text-xs
                                    font-medium
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                WhatsApp
                            </div>

                            <div
                                class="
                                    mt-1
                                    text-sm
                                    font-semibold
                                    text-gray-900
                                    dark:text-gray-100
                                "
                            >
                                {{ $corporateRequest->whatsapp }}
                            </div>

                        </div>


                        {{-- EMAIL --}}

                        <div>

                            <div
                                class="
                                    text-xs
                                    font-medium
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                Email
                            </div>

                            <div
                                class="
                                    mt-1
                                    text-sm
                                    font-semibold
                                    text-gray-900
                                    dark:text-gray-100
                                "
                            >
                                {{ $corporateRequest->email }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- TRIP INFORMATION --}}

                <div
                    class="
                        px-6 py-6
                        border-t
                        border-gray-200
                        dark:border-gray-700
                    "
                >

                    <h4
                        class="
                            mb-5
                            text-sm
                            font-semibold
                            uppercase
                            tracking-wide
                            text-gray-500
                            dark:text-gray-400
                        "
                    >
                        Informasi Acara
                    </h4>


                    <div
                        class="
                            grid
                            grid-cols-1
                            md:grid-cols-2
                            gap-6
                        "
                    >

                        {{-- DURATION --}}

                        <div>

                            <div
                                class="
                                    text-xs
                                    font-medium
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                Durasi Acara
                            </div>

                            <div
                                class="
                                    mt-1
                                    text-sm
                                    font-semibold
                                    text-gray-900
                                    dark:text-gray-100
                                "
                            >
                                {{ $corporateRequest->duration_days }}
                                Hari
                            </div>

                        </div>


                        {{-- PARTICIPANT --}}

                        <div>

                            <div
                                class="
                                    text-xs
                                    font-medium
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                Jumlah Peserta
                            </div>

                            <div
                                class="
                                    mt-1
                                    text-sm
                                    font-semibold
                                    text-gray-900
                                    dark:text-gray-100
                                "
                            >
                                {{ $corporateRequest->participant_count }}
                                Orang
                            </div>

                        </div>


                        {{-- HOTEL --}}

                        <div>

                            <div
                                class="
                                    text-xs
                                    font-medium
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                Include Hotel
                            </div>

                            <div class="mt-2">

                                @if ($corporateRequest->include_hotel)

                                    <span
                                        class="
                                            inline-flex
                                            px-3 py-1
                                            rounded-full
                                            bg-green-100
                                            text-green-700
                                            dark:bg-green-900/30
                                            dark:text-green-300
                                            text-xs
                                            font-semibold
                                        "
                                    >
                                        Ya
                                    </span>

                                @else

                                    <span
                                        class="
                                            inline-flex
                                            px-3 py-1
                                            rounded-full
                                            bg-gray-100
                                            text-gray-700
                                            dark:bg-gray-700
                                            dark:text-gray-300
                                            text-xs
                                            font-semibold
                                        "
                                    >
                                        Tidak
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- DEPARTURE --}}

                        <div>

                            <div
                                class="
                                    text-xs
                                    font-medium
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                Keberangkatan
                            </div>

                            <div
                                class="
                                    mt-1
                                    text-sm
                                    font-semibold
                                    text-gray-900
                                    dark:text-gray-100
                                "
                            >
                                {{ $corporateRequest->departure_location }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
