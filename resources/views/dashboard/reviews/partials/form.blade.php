<div class="space-y-6">


    {{-- CUSTOMER --}}

    <div>

        <label
            class="
                mb-2
                block
                text-sm
                font-medium
                text-gray-700
                dark:text-gray-300
            "
        >
            Nama Customer
        </label>

        <input
            type="text"
            name="cust_name"
            value="{{ old(
                'cust_name',
                $review->cust_name ?? ''
            ) }}"
            class="
                w-full
                rounded-lg
                border-gray-300
                dark:border-gray-700
                dark:bg-gray-900
                dark:text-white
            "
            required
        >

        @error('cust_name')
            <div class="mt-1 text-sm text-red-500">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- CITY --}}

    <div>

        <label
            class="
                mb-2
                block
                text-sm
                font-medium
                text-gray-700
                dark:text-gray-300
            "
        >
            Asal Kota
        </label>

        <input
            type="text"
            name="asal_kota"
            value="{{ old(
                'asal_kota',
                $review->asal_kota ?? ''
            ) }}"
            class="
                w-full
                rounded-lg
                border-gray-300
                dark:border-gray-700
                dark:bg-gray-900
                dark:text-white
            "
        >

    </div>


    {{-- RATING --}}

    <div>

        <label
            class="
                mb-2
                block
                text-sm
                font-medium
                text-gray-700
                dark:text-gray-300
            "
        >
            Rating
        </label>

        <select
            name="rating"
            class="
                w-full
                rounded-lg
                border-gray-300
                dark:border-gray-700
                dark:bg-gray-900
                dark:text-white
            "
            required
        >

            @for ($rating = 5; $rating >= 1; $rating--)

                <option
                    value="{{ $rating }}"
                    @selected(
                        old(
                            'rating',
                            $review->rating ?? 5
                        ) == $rating
                    )
                >
                    {{ str_repeat('★', $rating) }}
                    ({{ $rating }})
                </option>

            @endfor

        </select>

    </div>


    {{-- REVIEW --}}

    <div>

        <label
            class="
                mb-2
                block
                text-sm
                font-medium
                text-gray-700
                dark:text-gray-300
            "
        >
            Review
        </label>

        <textarea
            name="description"
            rows="6"
            class="
                w-full
                rounded-lg
                border-gray-300
                dark:border-gray-700
                dark:bg-gray-900
                dark:text-white
            "
        >{{ old(
            'description',
            $review->description ?? ''
        ) }}</textarea>

    </div>


    {{-- IMAGES --}}

    <div>

        <label
            class="
                mb-3
                block
                text-sm
                font-medium
                text-gray-700
                dark:text-gray-300
            "
        >
            Foto Review
        </label>


        <div
            class="
                grid
                grid-cols-1
                gap-4
                md:grid-cols-5
            "
        >

            @for ($i = 1; $i <= 5; $i++)

                <div>

                    <label
                        class="
                            mb-2
                            block
                            text-sm
                            text-gray-500
                        "
                    >
                        Foto {{ $i }}
                    </label>

                    <input
                        type="file"
                        name="image{{ $i }}"
                        accept="image/*"
                        class="
                            block
                            w-full
                            text-sm
                            dark:text-gray-300
                        "
                    >

                </div>

            @endfor

        </div>

    </div>


    {{-- STATUS --}}

    <div>

        <input
            type="hidden"
            name="status"
            value="0"
        >

        <label
            class="
                flex
                items-center
                gap-3
            "
        >

            <input
                type="checkbox"
                name="status"
                value="1"
                @checked(
                    old(
                        'status',
                        $review->status ?? true
                    )
                )
                class="
                    rounded
                    border-gray-300
                "
            >

            <span
                class="
                    text-sm
                    text-gray-700
                    dark:text-gray-300
                "
            >
                Aktif
            </span>

        </label>

    </div>


    {{-- BUTTON --}}

    <div
        class="
            flex
            justify-end
            gap-3
            border-t
            border-gray-200
            pt-6
            dark:border-gray-700
        "
    >

        <a
            href="{{ route(
                'admin.reviews.show',
                $travel->id
            ) }}"
            class="
                rounded-lg
                border
                border-gray-300
                px-5
                py-2
                dark:border-gray-700
                dark:text-white
            "
        >
            Batal
        </a>


        <button
            type="submit"
            class="
                rounded-lg
                bg-blue-600
                px-5
                py-2
                font-medium
                text-white
                hover:bg-blue-700
            "
        >
            Simpan Review
        </button>

    </div>

</div>
