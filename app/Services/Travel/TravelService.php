<?php

namespace App\Services\Travel;

use App\Models\Travel;
use App\Models\TravelInclude;
use App\Models\TravelOption;
use App\Models\TravelOptionPrice;
use App\Models\TravelOptionTime;
use App\Models\TravelAddon;
use App\Repositories\Travel\TravelRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TravelService
{
    public function __construct(
        private TravelRepository $travelRepository
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function paginate(int $perPage = 10)
    {
        return $this->travelRepository
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(array $data): Travel
    {
        return DB::transaction(function () use ($data) {

            /*
             * Upload images terlebih dahulu.
             */
            $images = $this->storeImages($data);

            /*
             * Data utama Travel.
             */
            $travelData = $this->prepareTravelData(
                $data
            );

            $travelData = array_merge(
                $travelData,
                $images
            );

            $travel = $this->travelRepository
                ->create($travelData);

            /*
             * Tags
             */
            $this->travelRepository->syncTags(
                $travel,
                $data['tags'] ?? []
            );

            /*
             * Includes
             */
            $this->createIncludes(
                $travel,
                $data['includes'] ?? []
            );

            /*
             * Options + Prices + Times + Addons
             */
            $this->createOptions(
                $travel,
                $data['options'] ?? []
            );

            return $this->travelRepository
                ->loadRelations($travel);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Travel $travel,
        array $data
    ): Travel {
        return DB::transaction(
            function () use ($travel, $data) {

                /*
                 * Upload image baru jika ada.
                 * Image lama tidak disentuh jika tidak ada upload.
                 */
                $images = $this->updateImages(
                    $travel,
                    $data
                );

                $travelData = $this->prepareTravelData(
                    $data
                );

                $travelData = array_merge(
                    $travelData,
                    $images
                );

                $travel = $this->travelRepository
                    ->update(
                        $travel,
                        $travelData
                    );

                /*
                 * Tags
                 */
                $this->travelRepository->syncTags(
                    $travel,
                    $data['tags'] ?? []
                );

                /*
                 * Nested children
                 */
                $this->syncIncludes(
                    $travel,
                    $data['includes'] ?? []
                );

                $this->syncOptions(
                    $travel,
                    $data['options'] ?? []
                );

                return $this->travelRepository
                    ->loadRelations($travel);
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(Travel $travel): void
    {
        DB::transaction(function () use ($travel) {

            /*
             * Simpan path sebelum record dihapus.
             */
            $images = [];

            for ($i = 1; $i <= 5; $i++) {
                $field = "image{$i}";

                if ($travel->{$field}) {
                    $images[] = $travel->{$field};
                }
            }

            /*
             * Child otomatis terhapus jika migration
             * menggunakan cascadeOnDelete().
             */
            $this->travelRepository->delete($travel);

            /*
             * Hapus file setelah DB delete berhasil.
             */
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Prepare Travel
    |--------------------------------------------------------------------------
    */

    private function prepareTravelData(
        array $data
    ): array {
        $isPickup = (bool) (
            $data['is_pickup'] ?? false
        );

        $isGroup = (bool) (
            $data['is_group'] ?? false
        );

        $isDiscount = (bool) (
            $data['is_discount'] ?? false
        );

        return [
            'travel_name' =>
                $data['travel_name'],

            'slug' =>
                $data['slug'],

            'short_description' =>
                $data['short_description'],

            'full_description' =>
                $data['full_description'],

            'cities_id' =>
                $data['cities_id'],

            'point_of_interest_id' =>
                $data['point_of_interest_id']
                    ?? null,

            'duration' =>
                $data['duration'],

            'duration_type' =>
                $data['duration_type'],

            'duration_hours' =>
                $this->calculateDurationHours(
                    (int) $data['duration'],
                    $data['duration_type']
                ),

            'is_pickup' =>
                $isPickup,

            'pickup_venue' =>
                $isPickup
                    ? ($data['pickup_venue'] ?? null)
                    : null,

            'is_corporate' =>
                (bool) (
                    $data['is_corporate'] ?? false
                ),

            'is_group' =>
                $isGroup,

            'jumlah_peserta' =>
                $isGroup
                    ? ($data['jumlah_peserta'] ?? null)
                    : null,

            'is_children' =>
                (bool) (
                    $data['is_children'] ?? false
                ),

            'is_discount' =>
                $isDiscount,

            'price_now' =>
                $data['price_now'],

            'price_discount' =>
                $isDiscount
                    ? ($data['price_discount'] ?? null)
                    : null,

            'status' =>
                (bool) (
                    $data['status'] ?? true
                ),
        ];
    }

    private function calculateDurationHours(
        int $duration,
        string $type
    ): int {
        return $type === 'hari'
            ? $duration * 24
            : $duration;
    }

    /*
    |--------------------------------------------------------------------------
    | Create Includes
    |--------------------------------------------------------------------------
    */

    private function createIncludes(
        Travel $travel,
        array $includes
    ): void {
        foreach ($includes as $index => $include) {

            $this->travelRepository
                ->createInclude(
                    $travel,
                    [
                        'include_desc' =>
                            $include['include_desc'],

                        'sort_order' =>
                            $index,
                    ]
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Create Options
    |--------------------------------------------------------------------------
    */

    private function createOptions(
        Travel $travel,
        array $options
    ): void {
        foreach ($options as $optionData) {

            $option = $this->travelRepository
                ->createOption(
                    $travel,
                    [
                        'option_name' =>
                            $optionData['option_name'],

                        'description' =>
                            $optionData['description']
                                ?? null,

                        'status' => (bool) ($optionData['status'] ?? true),
                    ]
                );

            $this->createPrices(
                $option,
                $optionData['prices'] ?? []
            );

            $this->createTimes(
                $option,
                $optionData['times'] ?? []
            );

            $this->createAddons(
                $option,
                $optionData['addons'] ?? []
            );
        }
    }

    private function createPrices(
        TravelOption $option,
        array $prices
    ): void {
        foreach ($prices as $price) {

            $this->travelRepository
                ->createPrice(
                    $option,
                    [
                        'type' =>
                            $price['type'],

                        'label' =>
                            $price['label'],

                        'min' =>
                            $price['min'],

                        'max' =>
                            $price['max'] ?? null,

                        'price' =>
                            $price['price'],

                        'status' =>
                            true,
                    ]
                );
        }
    }

    private function createTimes(
        TravelOption $option,
        array $times
    ): void {
        foreach ($times as $time) {

            $this->travelRepository
                ->createTime(
                    $option,
                    [
                        'time' =>
                            $time['time'],

                        'is_active' =>
                            true,

                        'status' =>
                            true,
                    ]
                );
        }
    }

    private function createAddons(
        TravelOption $option,
        array $addons
    ): void {
        foreach ($addons as $addon) {

            $this->travelRepository
                ->createAddon(
                    $option,
                    [
                        'addon_name' =>
                            $addon['addon_name'],

                        'description' =>
                            $addon['description']
                                ?? null,

                        'price' =>
                            $addon['price'],

                        'min' =>
                            $addon['min'] ?? 0,

                        'max' =>
                            $addon['max'] ?? 1,

                        'status' =>
                            true,
                    ]
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Sync Includes
    |--------------------------------------------------------------------------
    */

    private function syncIncludes(
        Travel $travel,
        array $includes
    ): void {
        $existingIds = [];

        foreach ($includes as $index => $data) {

            if (!empty($data['id'])) {

                /*
                 * Harus dicari melalui parent Travel.
                 */
                $include = $travel
                    ->includes()
                    ->whereKey($data['id'])
                    ->firstOrFail();

                $this->travelRepository
                    ->updateInclude(
                        $include,
                        [
                            'include_desc' =>
                                $data['include_desc'],

                            'sort_order' =>
                                $index,
                        ]
                    );

                $existingIds[] =
                    (int) $include->id;

                continue;
            }

            $include = $this->travelRepository
                ->createInclude(
                    $travel,
                    [
                        'include_desc' =>
                            $data['include_desc'],

                        'sort_order' =>
                            $index,
                    ]
                );

            $existingIds[] =
                (int) $include->id;
        }

        $this->travelRepository
            ->deleteIncludesNotIn(
                $travel,
                $existingIds
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Sync Options
    |--------------------------------------------------------------------------
    */

    private function syncOptions(
        Travel $travel,
        array $options
    ): void {
        $existingOptionIds = [];

        foreach ($options as $optionData) {

            if (!empty($optionData['id'])) {

                /*
                 * Jangan TravelOption::find().
                 *
                 * Pastikan option memang milik
                 * Travel yang sedang diedit.
                 */
                $option = $travel
                    ->options()
                    ->whereKey($optionData['id'])
                    ->firstOrFail();

                $this->travelRepository->updateOption(
                    $option,
                    [
                        'option_name' => $optionData['option_name'],
                        'description' => $optionData['description'] ?? null,
                        'status' => (bool) ($optionData['status'] ?? true),
                    ]
                );

            } else {

                $option = $this->travelRepository->createOption(
                    $travel,
                    [
                        'option_name' => $optionData['option_name'],
                        'description' => $optionData['description'] ?? null,
                        'status' => (bool) ($optionData['status'] ?? true),
                    ]
                );
            }

            $existingOptionIds[] =
                (int) $option->id;

            /*
             * Sync children option.
             */
            $this->syncPrices(
                $option,
                $optionData['prices'] ?? []
            );

            $this->syncTimes(
                $option,
                $optionData['times'] ?? []
            );

            $this->syncAddons(
                $option,
                $optionData['addons'] ?? []
            );
        }

        /*
         * Option yang dihapus dari UI
         * akan dihapus dari DB.
         */
        $this->travelRepository
            ->deleteOptionsNotIn(
                $travel,
                $existingOptionIds
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Sync Prices
    |--------------------------------------------------------------------------
    */

    private function syncPrices(
        TravelOption $option,
        array $prices
    ): void {
        $existingIds = [];

        foreach ($prices as $data) {

            $payload = [
                'type' =>
                    $data['type'],

                'label' =>
                    $data['label'],

                'min' =>
                    $data['min'],

                'max' =>
                    $data['max'] ?? null,

                'price' =>
                    $data['price'],

                'status' =>
                    true,
            ];

            if (!empty($data['id'])) {

                $price = $option
                    ->prices()
                    ->whereKey($data['id'])
                    ->firstOrFail();

                $this->travelRepository
                    ->updatePrice(
                        $price,
                        $payload
                    );

            } else {

                $price = $this->travelRepository
                    ->createPrice(
                        $option,
                        $payload
                    );
            }

            $existingIds[] =
                (int) $price->id;
        }

        $this->travelRepository
            ->deletePricesNotIn(
                $option,
                $existingIds
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Sync Times
    |--------------------------------------------------------------------------
    */

    private function syncTimes(
        TravelOption $option,
        array $times
    ): void {
        $existingIds = [];

        foreach ($times as $data) {

            $payload = [
                'time' =>
                    $data['time'],

                'is_active' =>
                    true,

                'status' =>
                    true,
            ];

            if (!empty($data['id'])) {

                $time = $option
                    ->times()
                    ->whereKey($data['id'])
                    ->firstOrFail();

                $this->travelRepository
                    ->updateTime(
                        $time,
                        $payload
                    );

            } else {

                $time = $this->travelRepository
                    ->createTime(
                        $option,
                        $payload
                    );
            }

            $existingIds[] =
                (int) $time->id;
        }

        $this->travelRepository
            ->deleteTimesNotIn(
                $option,
                $existingIds
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Sync Addons
    |--------------------------------------------------------------------------
    */

    private function syncAddons(
        TravelOption $option,
        array $addons
    ): void {
        $existingIds = [];

        foreach ($addons as $data) {

            $payload = [
                'addon_name' =>
                    $data['addon_name'],

                'description' =>
                    $data['description'] ?? null,

                'price' =>
                    $data['price'],

                'min' =>
                    $data['min'] ?? 0,

                'max' =>
                    $data['max'] ?? 1,

                'status' =>
                    true,
            ];

            if (!empty($data['id'])) {

                $addon = $option
                    ->addons()
                    ->whereKey($data['id'])
                    ->firstOrFail();

                $this->travelRepository
                    ->updateAddon(
                        $addon,
                        $payload
                    );

            } else {

                $addon = $this->travelRepository
                    ->createAddon(
                        $option,
                        $payload
                    );
            }

            $existingIds[] =
                (int) $addon->id;
        }

        $this->travelRepository
            ->deleteAddonsNotIn(
                $option,
                $existingIds
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    */

    private function storeImages(
        array $data
    ): array {
        $images = [];

        for ($i = 1; $i <= 5; $i++) {

            $field = "image{$i}";

            if (
                isset($data[$field]) &&
                $data[$field]
            ) {
                $images[$field] =
                    $data[$field]->store(
                        'travels',
                        'public'
                    );
            }
        }

        return $images;
    }

    private function updateImages(
    Travel $travel,
    array $data
): array {
    $images = [];

    for ($i = 1; $i <= 5; $i++) {

        $field = "image{$i}";

        if (
            !isset($data[$field]) ||
            !$data[$field]
        ) {
            continue;
        }

        $images[$field] =
            $data[$field]->store(
                'travels',
                'public'
            );
    }

    return $images;
}

public function getDetail(
    Travel $travel
): Travel {
    return $this->travelRepository
        ->loadRelations($travel);
}

public function getPublicTravels(
    int $perPage = 12,
    ?string $search = null,
    ?string $citySlug = null,
    ?string $poiSlug = null,
    ?string $tagSlug = null,
    ?string $sort = null,
    bool $isCorporate = false
): LengthAwarePaginator {

    return $this->travelRepository->paginateActive(
        $perPage,
        $search,
        $citySlug,
        $poiSlug,
        $tagSlug,
        $sort,
        $isCorporate
    );
}

public function getPublicDetail(
    string $slug
): Travel {
    return $this->travelRepository
        ->findActiveBySlug($slug);
}
}
