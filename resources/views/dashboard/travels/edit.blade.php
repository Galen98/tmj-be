<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a
                    href="{{ route('admin.travels.index') }}"
                    class="hover:text-blue-600"
                >
                    Paket Wisata
                </a>

                <span>/</span>

                <a
                    href="{{ route('admin.travels.show', $travel) }}"
                    class="hover:text-blue-600"
                >
                    {{ $travel->travel_name }}
                </a>

                <span>/</span>
                <span>Edit</span>
            </div>

            <h2 class="mt-2 text-xl font-semibold text-gray-800 dark:text-gray-100">
                Edit Paket Wisata
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $travel->travel_name }}
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form
                action="{{ route('admin.travels.update', $travel) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                @include('dashboard.travels.partials.form', [
                    'travel' => $travel,
                ])
            </form>
        </div>
    </div>
</x-app-layout>
