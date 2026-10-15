<x-app-layout>

    <x-slot name="header">

        <h2
            class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
        >
            Parameter Global
        </h2>

    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))

                <div
                    class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg"
                >
                    {{ session('success') }}
                </div>

            @endif


            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
            >

                <div class="p-6">

                    <div class="space-y-6">

                        @foreach ($parameters as $parameter)

                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.parameter-global.update',
                                    $parameter
                                ) }}"
                            >

                                @csrf
                                @method('PUT')


                                <div
                                    class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end"
                                >

                                    {{-- NAME --}}

                                    <div>

                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                        >
                                            Parameter
                                        </label>

                                        <input
                                            type="text"
                                            value="{{ $parameter->name }}"
                                            disabled
                                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-300"
                                        >

                                    </div>


                                    {{-- VALUE --}}

                                    <div class="md:col-span-2">

                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                        >
                                            Value
                                        </label>


                                        @if ($parameter->name === 'MAIL_PASSWORD')

                                            <input
                                                type="password"
                                                name="value"
                                                value="{{ $parameter->value }}"
                                                autocomplete="new-password"
                                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200"
                                            >

                                        @else

                                            <input
                                                type="text"
                                                name="value"
                                                value="{{ $parameter->value }}"
                                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200"
                                            >

                                        @endif

                                    </div>


                                    {{-- UPDATE --}}

                                    <div>

                                        <button
                                            type="submit"
                                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                                        >
                                            Update
                                        </button>

                                    </div>

                                </div>

                            </form>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
