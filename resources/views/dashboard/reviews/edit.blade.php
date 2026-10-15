<x-app-layout>

    <x-slot name="header">

        <h2
            class="
                text-xl
                font-semibold
                text-gray-800
                dark:text-gray-200
            "
        >
            Berikan Rating
        </h2>

    </x-slot>


    <div class="py-6">

        <div
            class="
                mx-auto
                max-w-4xl
                px-4
                sm:px-6
                lg:px-8
            "
        >

            <div
                class="
                    mb-5
                    rounded-xl
                    bg-white
                    p-5
                    shadow
                    dark:bg-gray-800
                "
            >

                <div
                    class="
                        text-sm
                        text-gray-500
                    "
                >
                    Travel
                </div>

                <div
                    class="
                        text-lg
                        font-semibold
                        text-gray-900
                        dark:text-white
                    "
                >
                    {{ $travel->travel_name }}
                </div>

            </div>


            <div
                class="
                    rounded-xl
                    bg-white
                    p-6
                    shadow
                    dark:bg-gray-800
                "
            >

               <form
                    method="POST"
                    action="{{ route(
                        'admin.reviews.update',
                        [
                            $travel->id,
                            $review->id,
                        ]
                    ) }}"
                    enctype="multipart/form-data"
                >

                    @csrf
                    @method('PUT')

                    @include(
                        'dashboard.reviews.partials.form',
                        [
                            'travel' => $travel,
                            'review' => $review,
                        ]
                    )

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
