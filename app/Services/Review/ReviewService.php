<?php

namespace App\Services\Review;

use App\Models\Review;
use App\Models\Travel;
use App\Repositories\Review\ReviewRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReviewService
{
    public function __construct(
        private ReviewRepository $repository
    ) {
    }


    /*
     * =========================================
     * TRAVEL LIST
     * =========================================
     */

    public function getTravels(
        int $perPage = 10,
        ?string $search = null
    ): LengthAwarePaginator {

        return $this->repository
            ->paginateTravels(
                $perPage,
                $search
            );
    }


    /*
     * =========================================
     * TRAVEL DETAIL
     * =========================================
     */

    public function getTravel(
        int $travelId
    ): Travel {

        return $this->repository
            ->findTravel($travelId);
    }


    /*
     * =========================================
     * REVIEWS
     * =========================================
     */

    public function getReviews(
        int $travelId,
        int $perPage = 10
    ): LengthAwarePaginator {

        return $this->repository
            ->paginateReviews(
                $travelId,
                $perPage
            );
    }


    /*
     * =========================================
     * CREATE REVIEW
     * =========================================
     */

    public function create(
        int $travelId,
        array $data
    ): Review {

        return DB::transaction(
            function () use (
                $travelId,
                $data
            ) {

                $data['travel_id'] =
                    $travelId;


                /*
                 * Review dibuat admin.
                 */

                $data['booking_id'] = null;
                $data['token'] = null;
                $data['expired_at'] = null;


                $data =
                    $this->storeImages(
                        $data
                    );


                return $this->repository
                    ->create($data);

            }
        );
    }


    /*
     * =========================================
     * UPDATE REVIEW
     * =========================================
     */

    public function update(
        int $travelId,
        int $reviewId,
        array $data
    ): Review {

        $review =
            $this->repository
                ->findReview(
                    $travelId,
                    $reviewId
                );


        return DB::transaction(
            function () use (
                $review,
                $data
            ) {

                $data =
                    $this->updateImages(
                        $review,
                        $data
                    );


                return $this->repository
                    ->update(
                        $review,
                        $data
                    );

            }
        );
    }


    /*
     * =========================================
     * DELETE
     * =========================================
     */

    public function delete(
        int $travelId,
        int $reviewId
    ): void {

        $review =
            $this->repository
                ->findReview(
                    $travelId,
                    $reviewId
                );


        DB::transaction(
            function () use ($review) {

                for (
                    $i = 1;
                    $i <= 5;
                    $i++
                ) {

                    $field =
                        'image' . $i;


                    if ($review->{$field}) {

                        Storage::disk('public')
                            ->delete(
                                $review->{$field}
                            );

                    }

                }


                $this->repository
                    ->delete($review);

            }
        );
    }


    /*
     * =========================================
     * STORE IMAGES
     * =========================================
     */

    private function storeImages(
        array $data
    ): array {

        for (
            $i = 1;
            $i <= 5;
            $i++
        ) {

            $field =
                'image' . $i;


            if (
                isset($data[$field]) &&
                $data[$field] instanceof UploadedFile
            ) {

                $data[$field] =
                    $data[$field]
                        ->store(
                            'reviews',
                            'public'
                        );

            }

        }


        return $data;
    }


    /*
     * =========================================
     * UPDATE IMAGES
     * =========================================
     */

    private function updateImages(
        Review $review,
        array $data
    ): array {

        for (
            $i = 1;
            $i <= 5;
            $i++
        ) {

            $field =
                'image' . $i;


            if (
                isset($data[$field]) &&
                $data[$field] instanceof UploadedFile
            ) {

                if ($review->{$field}) {

                    Storage::disk('public')
                        ->delete(
                            $review->{$field}
                        );

                }


                $data[$field] =
                    $data[$field]
                        ->store(
                            'reviews',
                            'public'
                        );

            } else {

                unset(
                    $data[$field]
                );

            }

        }


        return $data;
    }

    public function getReview(
        int $travelId,
        int $reviewId
    ): Review {

        return $this->repository
            ->findReview(
                $travelId,
                $reviewId
            );
    }
}
