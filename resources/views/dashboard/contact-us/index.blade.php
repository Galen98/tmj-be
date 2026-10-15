<x-app-layout>

    <x-slot name="header">
        <h2
            class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
        >
            {{ __('Contact Us') }}
        </h2>
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS --}}
            @if (session('success'))

                <div
                    class="mb-4 p-4 rounded-lg bg-green-100 text-green-700"
                >
                    {{ session('success') }}
                </div>

            @endif


            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
            >

                <div class="p-6">


                    {{-- SEARCH --}}
                    <form
                        method="GET"
                        action="{{ route('admin.contact-us.index') }}"
                        class="mb-6"
                    >

                        <div class="flex flex-col sm:flex-row gap-3">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama, email, atau pesan..."
                                class="
                                    w-full sm:max-w-md
                                    rounded-md
                                    border-gray-300
                                    dark:border-gray-700
                                    dark:bg-gray-900
                                    dark:text-gray-300
                                "
                            >

                            <button
                                type="submit"
                                class="
                                    px-5 py-2
                                    bg-blue-600
                                    text-white
                                    rounded-md
                                    hover:bg-blue-700
                                "
                            >
                                Cari
                            </button>

                        </div>

                    </form>


                    {{-- TABLE --}}
                    <div class="overflow-x-auto">

                        <table
                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                        >

                            <thead>

                                <tr>

                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                    >
                                        No
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Nama
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Email
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Pesan
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Status
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Tanggal
                                    </th>

                                    <th
                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody
                                class="divide-y divide-gray-200 dark:divide-gray-700"
                            >

                                @forelse ($contacts as $contact)

                                    <tr
                                        class="{{ !$contact->is_read ? 'bg-blue-50 dark:bg-gray-700/50' : '' }}"
                                    >

                                        {{-- NO --}}
                                        <td
                                            class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300"
                                        >
                                            {{
                                                ($contacts->currentPage() - 1)
                                                * $contacts->perPage()
                                                + $loop->iteration
                                            }}
                                        </td>


                                        {{-- NAME --}}
                                        <td
                                            class="
                                                px-4 py-4
                                                text-sm
                                                {{ !$contact->is_read
                                                    ? 'font-bold text-gray-900 dark:text-white'
                                                    : 'text-gray-700 dark:text-gray-300'
                                                }}
                                            "
                                        >
                                            {{ $contact->name }}
                                        </td>


                                        {{-- EMAIL --}}
                                        <td
                                            class="
                                                px-4 py-4
                                                text-sm
                                                {{ !$contact->is_read
                                                    ? 'font-semibold text-gray-900 dark:text-white'
                                                    : 'text-gray-600 dark:text-gray-300'
                                                }}
                                            "
                                        >
                                            {{ $contact->email }}
                                        </td>


                                        {{-- MESSAGE --}}
                                        <td
                                            class="
                                                px-4 py-4
                                                text-sm
                                                max-w-xs
                                                {{ !$contact->is_read
                                                    ? 'font-semibold text-gray-900 dark:text-white'
                                                    : 'text-gray-600 dark:text-gray-300'
                                                }}
                                            "
                                        >
                                            {{
                                                \Illuminate\Support\Str::limit(
                                                    $contact->message,
                                                    60
                                                )
                                            }}
                                        </td>


                                        {{-- STATUS --}}
                                        <td class="px-4 py-4">

                                            @if ($contact->is_read)

                                                <span
                                                    class="
                                                        px-2.5 py-1
                                                        text-xs
                                                        font-semibold
                                                        rounded-full
                                                        bg-gray-100
                                                        text-gray-600
                                                    "
                                                >
                                                    Read
                                                </span>

                                            @else

                                                <span
                                                    class="
                                                        px-2.5 py-1
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

                                        </td>


                                        {{-- DATE --}}
                                        <td
                                            class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap"
                                        >
                                            {{
                                                $contact->created_at
                                                    ->format('d M Y H:i')
                                            }}
                                        </td>


                                        {{-- ACTION --}}
                                        <td
                                            class="px-4 py-4 text-right"
                                        >

                                            <a
                                                href="{{
                                                    route(
                                                        'admin.contact-us.show',
                                                        $contact
                                                    )
                                                }}"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    px-3 py-2
                                                    text-sm
                                                    font-medium
                                                    text-white
                                                    bg-blue-600
                                                    rounded-md
                                                    hover:bg-blue-700
                                                "
                                            >
                                                Buka
                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="7"
                                            class="px-4 py-10 text-center text-gray-500"
                                        >
                                            Belum ada pesan masuk.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- PAGINATION --}}
                    @if ($contacts->hasPages())

                        <div class="mt-6">
                            {{ $contacts->withQueryString()->links() }}
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
