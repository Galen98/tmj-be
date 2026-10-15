<?php

namespace App\Repositories\Review;

use App\Models\Review;
use App\Models\Travel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewRepository
{
    /*
     * =========================================
     * TRAVEL LIST
     * =========================================
     */

    public function paginateTravels(
        int $perPage = 10,
        ?string $search = null
    ): LengthAwarePaginator {

        return Travel::query()
            ->withCount([
                'reviews',
            ])
            ->withAvg(
                'reviews',
                'rating'
            )
            ->when(
                $search,
                function ($query) use ($search) {

                    $query->where(
                        'travel_name',
                        'like',
                        '%' . $search . '%'
                    );

                }
            )
            ->orderBy('travel_name')
            ->paginate($perPage);
    }


    /*
     * =========================================
     * FIND TRAVEL
     * =========================================
     */

    public function findTravel(
        int $travelId
    ): Travel {

        return Travel::query()
            ->findOrFail($travelId);
    }


    /*
     * =========================================
     * REVIEW LIST
     * =========================================
     */

    public function paginateReviews(
        int $travelId,
        int $perPage = 10
    ): LengthAwarePaginator {

        return Review::query()
            ->where(
                'travel_id',
                $travelId
            )
            ->latest()
            ->paginate($perPage);
    }


    /*
     * =========================================
     * CREATE
     * =========================================
     */

    public function create(
        array $data
    ): Review {

        return Review::query()
            ->create($data);
    }


    /*
     * =========================================
     * FIND REVIEW
     * =========================================
     */

    public function findReview(
        int $travelId,
        int $reviewId
    ): Review {

        return Review::query()
            ->where(
                'travel_id',
                $travelId
            )
            ->findOrFail($reviewId);
    }


    /*
     * =========================================
     * UPDATE
     * =========================================
     */

    public function update(
        Review $review,
        array $data
    ): Review {

        $review->update($data);

        return $review->refresh();
    }


    /*
     * =========================================
     * DELETE
     * =========================================
     */

    public function delete(
        Review $review
    ): void {

        $review->delete();
    }
}
