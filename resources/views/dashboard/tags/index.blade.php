<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Kategori
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Aktifkan atau nonaktifkan Kategori yang ditampilkan pada website.
            </p>
        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

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
                    shadow-sm
                    sm:rounded-lg
                    overflow-hidden
                "
            >

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
                                    Kategori
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                    Slug
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                    Icon
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-gray-500">
                                    Status
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

                            @foreach ($tags as $tag)

                                <tr>

                                    <td class="px-6 py-4">

                                        <div
                                            class="
                                                font-semibold
                                                text-gray-900
                                                dark:text-gray-100
                                            "
                                        >
                                            {{ $tag->name }}
                                        </div>

                                    </td>


                                    <td
                                        class="
                                            px-6 py-4
                                            text-sm
                                            text-gray-500
                                            dark:text-gray-400
                                        "
                                    >
                                        {{ $tag->slug }}
                                    </td>


                                    <td
                                        class="
                                            px-6 py-4
                                            text-sm
                                            text-gray-500
                                            dark:text-gray-400
                                        "
                                    >
                                        {{ $tag->icon ?? '-' }}
                                    </td>


                                    <td class="px-6 py-4">

                                        <div class="flex justify-end">

                                            <form
                                                action="{{ route('admin.tags.status', $tag->id) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="{{ $tag->status ? 0 : 1 }}"
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
                                                        {{ $tag->status
                                                            ? 'bg-blue-600'
                                                            : 'bg-gray-300 dark:bg-gray-600'
                                                        }}
                                                    "
                                                    title="{{ $tag->status ? 'Nonaktifkan' : 'Aktifkan' }}"
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
                                                            {{ $tag->status
                                                                ? 'translate-x-6'
                                                                : 'translate-x-1'
                                                            }}
                                                        "
                                                    ></span>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
