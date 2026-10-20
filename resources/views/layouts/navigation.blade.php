<nav
     x-data="{
        open: false,

        darkMode: localStorage.getItem('theme')
            ? localStorage.getItem('theme') === 'dark'
            : window.matchMedia('(prefers-color-scheme: dark)').matches,

        init() {
            this.applyTheme();
        },

        toggleTheme() {
            this.darkMode = !this.darkMode;

            localStorage.setItem(
                'theme',
                this.darkMode ? 'dark' : 'light'
            );

            this.applyTheme();
        },

        applyTheme() {
            document.documentElement.classList.toggle(
                'dark',
                this.darkMode
            );
        }
    }"
    x-init="init()"
    class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700"
>

    <!-- =========================================
        PRIMARY NAVIGATION
    ========================================== -->

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <div class="flex">

                <!-- =========================================
                    LOGO
                ========================================== -->

                <div class="shrink-0 flex items-center">

                    <a href="{{ route('admin.dashboard.analytics') }}">

                        <img
                            src="{{ asset('images/misc/icon.png') }}"
                            alt="Travel Murah Jogja"
                            class="block h-10 w-auto object-contain"
                        />

                    </a>

                </div>


                <!-- =========================================
                    DESKTOP NAVIGATION
                ========================================== -->

                <div
                    class="hidden sm:flex sm:items-center sm:ms-10 space-x-8"
                >

                    <!-- DASHBOARD -->

                    <x-nav-link
                        :href="route('admin.dashboard.analytics')"
                        :active="request()->routeIs('admin.dashboard.analytics')"
                    >
                        {{ __('Dashboard') }}
                    </x-nav-link>


                    <!-- TRAVELS DROPDOWN -->

                    <div
                        class="relative h-full flex items-center"
                        x-data="{ open: false }"
                    >

                        <button
                            type="button"
                            @click="open = !open"
                            @click.outside="open = false"
                            class="
                                inline-flex
                                items-center
                                gap-1
                                h-full
                                px-1
                                text-sm
                                font-medium
                                text-gray-500
                                dark:text-gray-400
                                hover:text-gray-700
                                dark:hover:text-gray-300
                                focus:outline-none
                                transition
                            "
                        >

                            Travels

                            <svg
                                class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-180': open }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>

                        </button>


                        <!-- DROPDOWN -->

                        <div
                            x-show="open"
                            x-transition
                            x-cloak
                            class="
                                absolute
                                left-0
                                top-full
                                z-50
                                mt-1
                                w-56
                                overflow-hidden
                                rounded-lg
                                bg-white
                                dark:bg-gray-800
                                shadow-lg
                                ring-1
                                ring-black
                                ring-opacity-5
                            "
                        >

                            <a
                                href="{{ route('admin.cities.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                City
                            </a>


                            <a
                                href="{{ route('admin.point-of-interests.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Point of Interest
                            </a>

                            <a
                                href="{{ route('admin.tags.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Kategori
                            </a>

                            <a
                                href="{{ route('admin.reviews.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Rating & Review
                            </a>

                            <a
                                href="{{ route('admin.travels.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Travels
                            </a>

                        </div>

                    </div>

                    <div
                        class="relative h-full flex items-center"
                        x-data="{ open: false }"
                    >
                        <button
                            type="button"
                            @click="open = !open"
                            @click.outside="open = false"
                            class="
                                inline-flex
                                items-center
                                gap-1
                                h-full
                                px-1
                                text-sm
                                font-medium
                                text-gray-500
                                dark:text-gray-400
                                hover:text-gray-700
                                dark:hover:text-gray-300
                                focus:outline-none
                                transition
                            "
                        >
                            Travel Settings
                            <svg
                                class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-180': open }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>


                        <!-- DROPDOWN -->

                        <div
                            x-show="open"
                            x-transition
                            x-cloak
                            class="
                                absolute
                                left-0
                                top-full
                                z-50
                                mt-1
                                w-56
                                overflow-hidden
                                rounded-lg
                                bg-white
                                dark:bg-gray-800
                                shadow-lg
                                ring-1
                                ring-black
                                ring-opacity-5
                            "
                        >

                            <a
                                href="{{ route('admin.vouchers.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Vouchers
                            </a>

                            <a
                                href="{{ route('admin.date-availabilities.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Date Availability
                            </a>
                </div>
                </div>

                <div
                        class="relative h-full flex items-center"
                        x-data="{ open: false }"
                    >
                        <button
                            type="button"
                            @click="open = !open"
                            @click.outside="open = false"
                            class="
                                inline-flex
                                items-center
                                gap-1
                                h-full
                                px-1
                                text-sm
                                font-medium
                                text-gray-500
                                dark:text-gray-400
                                hover:text-gray-700
                                dark:hover:text-gray-300
                                focus:outline-none
                                transition
                            "
                        >
                            Utility
                            <svg
                                class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-180': open }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>


                        <!-- DROPDOWN -->

                        <div
                            x-show="open"
                            x-transition
                            x-cloak
                            class="
                                absolute
                                left-0
                                top-full
                                z-50
                                mt-1
                                w-56
                                overflow-hidden
                                rounded-lg
                                bg-white
                                dark:bg-gray-800
                                shadow-lg
                                ring-1
                                ring-black
                                ring-opacity-5
                            "
                        >

                            <a
                                href="{{ route('admin.parameter-global.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Parameter Settings
                            </a>

                            <a
                                href="{{ route('admin.backgrounds.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Background
                            </a>
                </div>
                </div>

                <div
                        class="relative h-full flex items-center"
                        x-data="{ open: false }"
                    >
                        <button
                            type="button"
                            @click="open = !open"
                            @click.outside="open = false"
                            class="
                                inline-flex
                                items-center
                                gap-1
                                h-full
                                px-1
                                text-sm
                                font-medium
                                text-gray-500
                                dark:text-gray-400
                                hover:text-gray-700
                                dark:hover:text-gray-300
                                focus:outline-none
                                transition
                            "
                        >
                            Customer Services
                            <svg
                                class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-180': open }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>


                        <!-- DROPDOWN -->

                        <div
                            x-show="open"
                            x-transition
                            x-cloak
                            class="
                                absolute
                                left-0
                                top-full
                                z-50
                                mt-1
                                w-56
                                overflow-hidden
                                rounded-lg
                                bg-white
                                dark:bg-gray-800
                                shadow-lg
                                ring-1
                                ring-black
                                ring-opacity-5
                            "
                        >

                            <a
                                href="{{ route('admin.email-customers.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Email Customer
                            </a>

                            <a
                                href="{{ route('admin.contact-us.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Messages
                            </a>

                            <a
                                href="{{ route('admin.cities.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Broadcast to Customer
                            </a>
                </div>
                </div>

                <div
                        class="relative h-full flex items-center"
                        x-data="{ open: false }"
                    >
                        <button
                            type="button"
                            @click="open = !open"
                            @click.outside="open = false"
                            class="
                                inline-flex
                                items-center
                                gap-1
                                h-full
                                px-1
                                text-sm
                                font-medium
                                text-gray-500
                                dark:text-gray-400
                                hover:text-gray-700
                                dark:hover:text-gray-300
                                focus:outline-none
                                transition
                            "
                        >
                            Korporasi
                            <svg
                                class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-180': open }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>


                        <!-- DROPDOWN -->

                        <div
                            x-show="open"
                            x-transition
                            x-cloak
                            class="
                                absolute
                                left-0
                                top-full
                                z-50
                                mt-1
                                w-56
                                overflow-hidden
                                rounded-lg
                                bg-white
                                dark:bg-gray-800
                                shadow-lg
                                ring-1
                                ring-black
                                ring-opacity-5
                            "
                        >

                            <a
                                href="{{ route('admin.corporate-requests.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Permintaan Korporasi
                            </a>
                </div>
                </div>

                <div
                        class="relative h-full flex items-center"
                        x-data="{ open: false }"
                    >
                        <button
                            type="button"
                            @click="open = !open"
                            @click.outside="open = false"
                            class="
                                inline-flex
                                items-center
                                gap-1
                                h-full
                                px-1
                                text-sm
                                font-medium
                                text-gray-500
                                dark:text-gray-400
                                hover:text-gray-700
                                dark:hover:text-gray-300
                                focus:outline-none
                                transition
                            "
                        >
                            Financial & Booking
                            <svg
                                class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-180': open }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>


                        <!-- DROPDOWN -->

                        <div
                            x-show="open"
                            x-transition
                            x-cloak
                            class="
                                absolute
                                left-0
                                top-full
                                z-50
                                mt-1
                                w-56
                                overflow-hidden
                                rounded-lg
                                bg-white
                                dark:bg-gray-800
                                shadow-lg
                                ring-1
                                ring-black
                                ring-opacity-5
                            "
                        >

                            <a
                                href="{{ route('admin.cities.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Daftar Booking
                            </a>

                            <a
                                href="{{ route('admin.cities.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Pembayaran & Keuangan
                            </a>

                            <a
                                href="{{ route('admin.cities.index') }}"
                                class="
                                    block
                                    px-4
                                    py-3
                                    text-sm
                                    text-gray-700
                                    dark:text-gray-300
                                    hover:bg-gray-100
                                    dark:hover:bg-gray-700
                                "
                            >
                                Approval Reschedule & Cancellation
                            </a>
                </div>
                </div>

                </div>

            </div>


            <!-- =========================================
                USER DROPDOWN
            ========================================== -->

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <button
                    type="button"
                    @click="toggleTheme()"
                    class="
                        me-3
                        inline-flex
                        items-center
                        justify-center
                        w-10
                        h-10
                        rounded-full
                        text-gray-500
                        dark:text-gray-300
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                        transition
                    "
                    aria-label="Ganti tema"
                >

                    <!-- MOON -->
                    <svg
                        x-show="!darkMode"
                        x-cloak
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3
                            7 7 0 0021 12.79z"
                        />
                    </svg>


                    <!-- SUN -->
                    <svg
                        x-show="darkMode"
                        x-cloak
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3
                            m15.364 6.364-.707-.707
                            M6.343 6.343l-.707-.707
                            m12.728 0-.707.707
                            M6.343 17.657l-.707.707
                            M16 12a4 4 0 11-8 0
                            4 4 0 018 0z"
                        />
                    </svg>

                </button>

                <x-dropdown
                    align="right"
                    width="48"
                >

                    <x-slot name="trigger">

                        <button
                            class="
                                inline-flex
                                items-center
                                px-3
                                py-2
                                border
                                border-transparent
                                text-sm
                                leading-4
                                font-medium
                                rounded-md
                                text-gray-500
                                dark:text-gray-400
                                bg-white
                                dark:bg-gray-800
                                hover:text-gray-700
                                dark:hover:text-gray-300
                                focus:outline-none
                                transition
                            "
                        >

                            <div>
                                {{ Auth::user()->name }}
                            </div>

                            <div class="ms-1">

                                <svg
                                    class="fill-current h-4 w-4"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>

                            </div>

                        </button>

                    </x-slot>


                    <x-slot name="content">

                        <x-dropdown-link
                            :href="route('profile.edit')"
                        >
                            {{ __('Profile') }}
                        </x-dropdown-link>


                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="
                                    event.preventDefault();
                                    this.closest('form').submit();
                                "
                            >
                                {{ __('Log Out') }}
                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            <!-- =========================================
                MOBILE HAMBURGER
            ========================================== -->

            <div class="-me-2 flex items-center sm:hidden">

                <button
                    @click="open = !open"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        p-2
                        rounded-md
                        text-gray-400
                        hover:text-gray-500
                        hover:bg-gray-100
                        focus:outline-none
                        transition
                    "
                >

                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >

                        <path
                            :class="{
                                'hidden': open,
                                'inline-flex': !open
                            }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />

                        <path
                            :class="{
                                'hidden': !open,
                                'inline-flex': open
                            }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />

                    </svg>

                </button>

            </div>

        </div>

    </div>


    <!-- =========================================
    MOBILE NAVIGATION
========================================== -->

<div
    :class="{
        'block': open,
        'hidden': !open
    }"
    class="hidden sm:hidden"
>

    <div class="pt-2 pb-3 space-y-1">

        <!-- =========================================
            DASHBOARD
        ========================================== -->

        <x-responsive-nav-link
            :href="route('admin.dashboard.analytics')"
            :active="request()->routeIs('admin.dashboard.analytics')"
        >
            {{ __('Dashboard') }}
        </x-responsive-nav-link>


        <!-- =========================================
            TRAVELS
        ========================================== -->

        <div x-data="{ openTravel: false }">

            <button
                type="button"
                @click="openTravel = !openTravel"
                class="
                    flex
                    items-center
                    justify-between
                    w-full
                    px-4
                    py-2
                    text-start
                    text-base
                    font-medium
                    text-gray-600
                    dark:text-gray-400
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                "
            >

                <span>
                    Travels
                </span>

                <svg
                    class="w-4 h-4 transition-transform"
                    :class="{
                        'rotate-180': openTravel
                    }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>

            </button>


            <div
                x-show="openTravel"
                x-cloak
                class="bg-gray-50 dark:bg-gray-900"
            >

                <a
                    href="{{ route('admin.cities.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    City
                </a>


                <a
                    href="{{ route('admin.point-of-interests.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Point of Interest
                </a>


                <a
                    href="{{ route('admin.tags.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Kategori
                </a>


                <a
                    href="{{ route('admin.tags.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Rating & Review
                </a>


                <a
                    href="{{ route('admin.travels.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Travel Package
                </a>

            </div>

        </div>


        <!-- =========================================
            TRAVEL SETTINGS
        ========================================== -->

        <div x-data="{ openTravelSettings: false }">

            <button
                type="button"
                @click="openTravelSettings = !openTravelSettings"
                class="
                    flex
                    items-center
                    justify-between
                    w-full
                    px-4
                    py-2
                    text-start
                    text-base
                    font-medium
                    text-gray-600
                    dark:text-gray-400
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                "
            >

                <span>
                    Travel Settings
                </span>

                <svg
                    class="w-4 h-4 transition-transform"
                    :class="{
                        'rotate-180': openTravelSettings
                    }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>

            </button>


            <div
                x-show="openTravelSettings"
                x-cloak
                class="bg-gray-50 dark:bg-gray-900"
            >

                <a
                    href="{{ route('admin.vouchers.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Vouchers
                </a>

                <a
                    href="{{ route('admin.date-availabilities.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Date Availability
                </a>

            </div>

        </div>


        <!-- =========================================
            UTILITY
        ========================================== -->

        <div x-data="{ openUtility: false }">

            <button
                type="button"
                @click="openUtility = !openUtility"
                class="
                    flex
                    items-center
                    justify-between
                    w-full
                    px-4
                    py-2
                    text-start
                    text-base
                    font-medium
                    text-gray-600
                    dark:text-gray-400
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                "
            >

                <span>
                    Utility
                </span>

                <svg
                    class="w-4 h-4 transition-transform"
                    :class="{
                        'rotate-180': openUtility
                    }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>

            </button>


            <div
                x-show="openUtility"
                x-cloak
                class="bg-gray-50 dark:bg-gray-900"
            >

                <a
                    href="{{ route('admin.parameter-global.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Parameter Settings
                </a>


                <a
                    href="{{ route('admin.backgrounds.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Background
                </a>

            </div>

        </div>


        <!-- =========================================
            CUSTOMER SERVICES
        ========================================== -->

        <div x-data="{ openCustomerService: false }">

            <button
                type="button"
                @click="openCustomerService = !openCustomerService"
                class="
                    flex
                    items-center
                    justify-between
                    w-full
                    px-4
                    py-2
                    text-start
                    text-base
                    font-medium
                    text-gray-600
                    dark:text-gray-400
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                "
            >

                <span>
                    Customer Services
                </span>

                <svg
                    class="w-4 h-4 transition-transform"
                    :class="{
                        'rotate-180': openCustomerService
                    }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>

            </button>


            <div
                x-show="openCustomerService"
                x-cloak
                class="bg-gray-50 dark:bg-gray-900"
            >

                <a
                    href="{{ route('admin.email-customers.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Email Customer
                </a>


                <a
                    href="{{ route('admin.contact-us.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Messages
                </a>


                <a
                    href="{{ route('admin.cities.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Broadcast to Customer
                </a>

            </div>

        </div>


        <!-- =========================================
            KORPORASI
        ========================================== -->

        <div x-data="{ openCorporate: false }">

            <button
                type="button"
                @click="openCorporate = !openCorporate"
                class="
                    flex
                    items-center
                    justify-between
                    w-full
                    px-4
                    py-2
                    text-start
                    text-base
                    font-medium
                    text-gray-600
                    dark:text-gray-400
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                "
            >

                <span>
                    Korporasi
                </span>

                <svg
                    class="w-4 h-4 transition-transform"
                    :class="{
                        'rotate-180': openCorporate
                    }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>

            </button>


            <div
                x-show="openCorporate"
                x-cloak
                class="bg-gray-50 dark:bg-gray-900"
            >

                <a
                    href="{{ route('admin.corporate-requests.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Permintaan Korporasi
                </a>

            </div>

        </div>


        <!-- =========================================
            FINANCIAL & BOOKING
        ========================================== -->

        <div x-data="{ openFinancial: false }">

            <button
                type="button"
                @click="openFinancial = !openFinancial"
                class="
                    flex
                    items-center
                    justify-between
                    w-full
                    px-4
                    py-2
                    text-start
                    text-base
                    font-medium
                    text-gray-600
                    dark:text-gray-400
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                "
            >

                <span>
                    Financial & Booking
                </span>

                <svg
                    class="w-4 h-4 transition-transform"
                    :class="{
                        'rotate-180': openFinancial
                    }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>

            </button>


            <div
                x-show="openFinancial"
                x-cloak
                class="bg-gray-50 dark:bg-gray-900"
            >

                <a
                    href="{{ route('admin.cities.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Daftar Booking
                </a>


                <a
                    href="{{ route('admin.cities.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Pembayaran & Keuangan
                </a>

                <a
                    href="{{ route('admin.cities.index') }}"
                    class="
                        block
                        py-2
                        ps-8
                        pe-4
                        text-sm
                        text-gray-600
                        dark:text-gray-400
                        hover:bg-gray-100
                        dark:hover:bg-gray-700
                    "
                >
                    Approval Reschedule & Cancellation
                </a>

            </div>

        </div>

    </div>


    <!-- =========================================
        MOBILE USER
    ========================================== -->

    <div
        class="
            pt-4
            pb-1
            border-t
            border-gray-200
            dark:border-gray-600
        "
    >

        <!-- USER -->

        <div class="px-4">

            <div
                class="
                    font-medium
                    text-base
                    text-gray-800
                    dark:text-gray-200
                "
            >
                {{ Auth::user()->name }}
            </div>

            <div
                class="
                    font-medium
                    text-sm
                    text-gray-500
                    dark:text-gray-400
                "
            >
                {{ Auth::user()->email }}
            </div>

        </div>


        <div class="mt-3 space-y-1">

            <!-- THEME SWITCHER -->

            <button
                type="button"
                @click="toggleTheme()"
                class="
                    flex
                    items-center
                    justify-between
                    w-full
                    px-4
                    py-2
                    text-start
                    text-base
                    font-medium
                    text-gray-600
                    dark:text-gray-400
                    hover:text-gray-800
                    dark:hover:text-gray-200
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                    transition
                "
            >

                <div class="flex items-center gap-3">

                    <!-- MOON -->

                    <svg
                        x-show="!darkMode"
                        x-cloak
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3
                               7 7 0 0021 12.79z"
                        />
                    </svg>


                    <!-- SUN -->

                    <svg
                        x-show="darkMode"
                        x-cloak
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3
                               m15.364 6.364-.707-.707
                               M6.343 6.343l-.707-.707
                               m12.728 0-.707.707
                               M6.343 17.657l-.707.707
                               M16 12a4 4 0 11-8 0
                               4 4 0 018 0z"
                        />
                    </svg>


                    <span>
                        Tampilan
                    </span>

                </div>


                <span
                    class="
                        text-sm
                        text-gray-500
                        dark:text-gray-400
                    "
                    x-text="darkMode ? 'Gelap' : 'Terang'"
                ></span>

            </button>


            <!-- PROFILE -->

            <x-responsive-nav-link
                :href="route('profile.edit')"
            >
                {{ __('Profile') }}
            </x-responsive-nav-link>


            <!-- LOGOUT -->

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <x-responsive-nav-link
                    :href="route('logout')"
                    onclick="
                        event.preventDefault();
                        this.closest('form').submit();
                    "
                >
                    {{ __('Log Out') }}
                </x-responsive-nav-link>

            </form>

        </div>

    </div>

</div>

</nav>
