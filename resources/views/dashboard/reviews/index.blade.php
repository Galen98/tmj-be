<x-app-layout>

    <x-slot name="header">

        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Review & Rating
        </h2>

    </x-slot>


    <div class="py-6">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- SEARCH --}}

            <div class="mb-6">

                <form
                    method="GET"
                    action="{{ route('admin.reviews.index') }}"
                    class="flex gap-3"
                >

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari travel..."
                        class="
                            w-full
                            rounded-lg
                            border-gray-300
                            bg-white
                            text-gray-900
                            dark:border-gray-700
                            dark:bg-gray-800
                            dark:text-white
                        "
                    >

                    <button
                        type="submit"
                        class="
                            rounded-lg
                            bg-blue-600
                            px-5
                            py-2
                            text-white
                            hover:bg-blue-700
                        "
                    >
                        Cari
                    </button>

                </form>

            </div>


            {{-- TABLE --}}

            <div
                class="
                    overflow-hidden
                    rounded-xl
                    bg-white
                    shadow
                    dark:bg-gray-800
                "
            >

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead
                            class="
                                bg-gray-50
                                dark:bg-gray-900
                            "
                        >

                            <tr>

                                <th class="px-6 py-4 text-left dark:text-white">
                                    Travel
                                </th>

                                <th class="px-6 py-4 text-center dark:text-white">
                                    Rating
                                </th>

                                <th class="px-6 py-4 text-center dark:text-white">
                                    Review
                                </th>

                                <th class="px-6 py-4 text-right dark:text-white">
                                    Aksi
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

                            @forelse ($travels as $travel)

                                <tr>

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-4">

                                            @if ($travel->image1)

                                                <img
                                                    src="{{ asset('storage/' . $travel->image1) }}"
                                                    class="
                                                        h-16
                                                        w-20
                                                        rounded-lg
                                                        object-cover
                                                    "
                                                >

                                            @endif


                                            <div>

                                                <div
                                                    class="
                                                        font-semibold
                                                        text-gray-900
                                                        dark:text-white
                                                    "
                                                >
                                                    {{ $travel->travel_name }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    <td
                                        class="
                                            px-6
                                            py-4
                                            text-center
                                            dark:text-white
                                        "
                                    >

                                        <span class="text-yellow-500">
                                            ★
                                        </span>

                                        {{ number_format(
                                            $travel->reviews_avg_rating ?? 0,
                                            1
                                        ) }}

                                    </td>


                                    <td
                                        class="
                                            px-6
                                            py-4
                                            text-center
                                            dark:text-white
                                        "
                                    >

                                        {{ $travel->reviews_count }}

                                    </td>


                                    <td
                                        class="
                                            px-6
                                            py-4
                                            text-right
                                        "
                                    >

                                        <a
                                            href="{{ route(
                                                'admin.reviews.show',
                                                $travel->id
                                            ) }}"
                                            class="
                                                rounded-lg
                                                bg-blue-600
                                                px-4
                                                py-2
                                                text-sm
                                                font-medium
                                                text-white
                                                hover:bg-blue-700
                                            "
                                        >
                                            Lihat Review
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="
                                            px-6
                                            py-10
                                            text-center
                                            text-gray-500
                                        "
                                    >
                                        Travel tidak ditemukan.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            <div class="mt-6">

                {{ $travels->withQueryString()->links() }}

            </div>

        </div>

    </div>

</x-app-layout>
