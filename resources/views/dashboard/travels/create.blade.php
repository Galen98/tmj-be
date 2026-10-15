<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a
                    href="{{ route('admin.travels.index') }}"
                    class="hover:text-blue-600"
                >
                    Paket Wisata
                </a>

                <span>/</span>
                <span>Tambah</span>
            </div>

            <h2 class="mt-2 text-xl font-semibold text-gray-800 dark:text-gray-100">
                Tambah Paket Wisata
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Lengkapi informasi paket, harga, pilihan perjalanan, waktu, dan add on.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form
                action="{{ route('admin.travels.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                @include('dashboard.travels.partials.form', [
                    'travel' => null,
                ])
            </form>
        </div>
    </div>
</x-app-layout>
