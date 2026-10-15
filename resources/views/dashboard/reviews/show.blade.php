<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2
                    class="
                        text-xl
                        font-semibold
                        text-gray-800
                        dark:text-gray-200
                    "
                >
                    Review {{ $travel->travel_name }}
                </h2>

            </div>


            <a
                href="{{ route(
                    'admin.reviews.create',
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
                + Berikan Rating
            </a>

        </div>

    </x-slot>


    <div class="py-6 dark:text-white">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            @if (session('success'))

                <div
                    class="
                        mb-5
                        rounded-lg
                        bg-green-100
                        p-4
                        text-green-800
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            <div
                class="
                    overflow-hidden
                    rounded-xl
                    bg-white
                    shadow
                    dark:bg-gray-800
                "
            >

                <table class="w-full">

                    <thead
                        class="
                            bg-gray-50
                            dark:bg-gray-900
                        "
                    >

                        <tr>

                            <th class="px-6 py-4 text-left">
                                Customer
                            </th>

                            <th class="px-6 py-4 text-left">
                                Kota
                            </th>

                            <th class="px-6 py-4 text-center">
                                Rating
                            </th>

                            <th class="px-6 py-4 text-left">
                                Review
                            </th>

                            <th class="px-6 py-4 text-center">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right">
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

                        @forelse ($reviews as $review)

                            <tr>

                                <td class="px-6 py-4">

                                    {{ $review->cust_name }}

                                </td>


                                <td class="px-6 py-4">

                                    {{ $review->asal_kota ?? '-' }}

                                </td>


                                <td
                                    class="
                                        px-6
                                        py-4
                                        text-center
                                    "
                                >

                                    <span class="text-yellow-500">

                                        @for ($i = 1; $i <= 5; $i++)

                                            {{ $i <= $review->rating ? '★' : '☆' }}

                                        @endfor

                                    </span>

                                </td>


                                <td
                                    class="
                                        max-w-md
                                        px-6
                                        py-4
                                    "
                                >

                                    {{ \Illuminate\Support\Str::limit(
                                        $review->description,
                                        100
                                    ) }}

                                </td>


                                <td
                                    class="
                                        px-6
                                        py-4
                                        text-center
                                    "
                                >

                                    @if ($review->status)

                                        <span
                                            class="
                                                rounded-full
                                                bg-green-100
                                                px-3
                                                py-1
                                                text-xs
                                                text-green-700
                                            "
                                        >
                                            Aktif
                                        </span>

                                    @else

                                        <span
                                            class="
                                                rounded-full
                                                bg-gray-100
                                                px-3
                                                py-1
                                                text-xs
                                                text-gray-700
                                            "
                                        >
                                            Nonaktif
                                        </span>

                                    @endif

                                </td>


                                <td
                                    class="
                                        px-6
                                        py-4
                                        text-right
                                    "
                                >

                                    <div
                                        class="
                                            flex
                                            justify-end
                                            gap-2
                                        "
                                    >

                                        <a
                                            href="{{ route(
                                                'admin.reviews.edit',
                                                [
                                                    $travel->id,
                                                    $review->id,
                                                ]
                                            ) }}"
                                            class="
                                                rounded
                                                bg-yellow-500
                                                px-3
                                                py-2
                                                text-sm
                                                text-white
                                            "
                                        >
                                            Edit
                                        </a>


                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.reviews.destroy',
                                                [
                                                    $travel->id,
                                                    $review->id,
                                                ]
                                            ) }}"
                                            onsubmit="
                                                return confirm(
                                                    'Hapus review ini?'
                                                )
                                            "
                                        >

                                            @csrf
                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="
                                                    rounded
                                                    bg-red-600
                                                    px-3
                                                    py-2
                                                    text-sm
                                                    text-white
                                                "
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="
                                        px-6
                                        py-12
                                        text-center
                                        text-gray-500
                                    "
                                >

                                    Belum ada review untuk travel ini.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-6">

                {{ $reviews->links() }}

            </div>

        </div>

    </div>

</x-app-layout>
