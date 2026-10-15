<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ __('Detail Contact Us') }}
            </h2>

            <a
                href="{{ route('admin.contact-us.index') }}"
                class="
                    text-sm
                    font-medium
                    text-blue-600
                    hover:text-blue-800
                    dark:text-blue-400
                "
            >
                ← Kembali
            </a>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">


            {{-- ========================================= --}}
            {{-- SUCCESS MESSAGE --}}
            {{-- ========================================= --}}

            @if (session('success'))

                <div
                    class="
                        mb-6
                        p-4
                        rounded-lg
                        bg-green-100
                        text-green-700
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- ========================================= --}}
            {{-- VALIDATION ERROR --}}
            {{-- ========================================= --}}

            @if ($errors->any())

                <div
                    class="
                        mb-6
                        p-4
                        rounded-lg
                        bg-red-100
                        text-red-700
                    "
                >

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- ========================================= --}}
            {{-- CUSTOMER MESSAGE --}}
            {{-- ========================================= --}}

            <div
                class="
                    bg-white
                    dark:bg-gray-800
                    overflow-hidden
                    shadow-sm
                    sm:rounded-lg
                    mb-6
                "
            >

                <div class="p-6">


                    {{-- HEADER --}}

                    <div
                        class="
                            flex
                            flex-col
                            sm:flex-row
                            sm:items-start
                            sm:justify-between
                            gap-4
                            mb-6
                        "
                    >

                        <div>

                            <h3
                                class="
                                    text-lg
                                    font-semibold
                                    text-gray-900
                                    dark:text-gray-100
                                "
                            >
                                {{ $contact->name }}
                            </h3>


                            <div
                                class="
                                    mt-1
                                    text-sm
                                    text-gray-500
                                    dark:text-gray-400
                                "
                            >
                                {{ $contact->email }}
                            </div>


                            <div
                                class="
                                    mt-1
                                    text-xs
                                    text-gray-400
                                    dark:text-gray-500
                                "
                            >
                                {{
                                    $contact->created_at
                                        ->format('d M Y H:i')
                                }}
                            </div>

                        </div>


                        {{-- STATUS --}}

                        <div>

                            @if ($contact->is_read)

                                <span
                                    class="
                                        inline-flex
                                        px-3 py-1
                                        text-xs
                                        font-semibold
                                        rounded-full
                                        bg-green-100
                                        text-green-700
                                    "
                                >
                                    Read
                                </span>

                            @else

                                <span
                                    class="
                                        inline-flex
                                        px-3 py-1
                                        text-xs
                                        font-semibold
                                        rounded-full
                                        bg-blue-100
                                        text-blue-700
                                    "
                                >
                                    Unread
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- DIVIDER --}}

                    <div
                        class="
                            border-t
                            border-gray-200
                            dark:border-gray-700
                            mb-6
                        "
                    ></div>


                    {{-- LABEL --}}

                    <div
                        class="
                            text-sm
                            font-medium
                            text-gray-500
                            dark:text-gray-400
                            mb-2
                        "
                    >
                        Pesan Customer
                    </div>


                    {{-- MESSAGE --}}

                    <div
                        class="
                            rounded-lg
                            bg-gray-50
                            dark:bg-gray-900
                            border
                            border-gray-200
                            dark:border-gray-700
                            p-4
                            text-sm
                            leading-relaxed
                            text-gray-700
                            dark:text-gray-300
                        "
                    >
                        {!! nl2br(
                            e($contact->message)
                        ) !!}
                    </div>

                </div>

            </div>


            {{-- ========================================= --}}
            {{-- REPLY --}}
            {{-- ========================================= --}}

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

                    <div class="mb-6">

                        <h3
                            class="
                                text-lg
                                font-semibold
                                text-gray-900
                                dark:text-gray-100
                            "
                        >
                            Balas Pesan
                        </h3>

                        <p
                            class="
                                mt-1
                                text-sm
                                text-gray-500
                                dark:text-gray-400
                            "
                        >
                            Balasan akan dikirim ke
                            <span class="font-medium">
                                {{ $contact->email }}
                            </span>
                            melalui email.
                        </p>

                    </div>


                    <form
                        method="POST"
                        action="{{
                            route(
                                'admin.contact-us.reply',
                                $contact
                            )
                        }}"
                    >

                        @csrf


                        {{-- TEXTAREA --}}

                        <div class="mb-6">

                            <label
                                for="message"
                                class="
                                    block
                                    mb-2
                                    text-sm
                                    font-medium
                                    text-gray-700
                                    dark:text-gray-300
                                "
                            >
                                Balasan
                            </label>


                            <textarea
                                id="message"
                                name="message"
                                rows="8"
                                required
                                placeholder="Tulis balasan kepada customer..."
                                class="
                                    block
                                    w-full
                                    rounded-md
                                    border-gray-300
                                    dark:border-gray-700
                                    dark:bg-gray-900
                                    dark:text-gray-300
                                    shadow-sm
                                    focus:border-blue-500
                                    focus:ring-blue-500
                                "
                            >{{ old('message') }}</textarea>


                            @error('message')

                                <p
                                    class="
                                        mt-2
                                        text-sm
                                        text-red-600
                                    "
                                >
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- ACTION --}}

                        <div
                            class="
                                flex
                                items-center
                                justify-end
                                gap-3
                            "
                        >

                            <a
                                href="{{
                                    route(
                                        'admin.contact-us.index'
                                    )
                                }}"
                                class="
                                    px-4 py-2
                                    text-sm
                                    font-medium
                                    text-gray-700
                                    dark:text-gray-300
                                    border
                                    border-gray-300
                                    dark:border-gray-600
                                    rounded-md
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
                                    text-sm
                                    font-medium
                                    text-white
                                    bg-blue-600
                                    rounded-md
                                    hover:bg-blue-700
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-blue-500
                                    focus:ring-offset-2
                                "
                            >
                                Kirim Balasan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
