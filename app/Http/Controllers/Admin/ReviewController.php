<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Review\StoreReviewRequest;
use App\Http\Requests\Admin\Review\UpdateReviewRequest;
use App\Services\Review\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewService $service
    ) {
    }


    /*
     * =========================================
     * TRAVEL LIST
     * =========================================
     */

    public function index(
        Request $request
    ): View {

        $travels =
            $this->service
                ->getTravels(
                    perPage: 10,
                    search:
                        $request->get(
                            'search'
                        )
                );


        return view(
            'dashboard.reviews.index',
            compact(
                'travels'
            )
        );
    }


    /*
     * =========================================
     * REVIEW LIST PER TRAVEL
     * =========================================
     */

    public function show(
        int $travelId
    ): View {

        $travel =
            $this->service
                ->getTravel(
                    $travelId
                );


        $reviews =
            $this->service
                ->getReviews(
                    $travelId
                );


        return view(
            'dashboard.reviews.show',
            compact(
                'travel',
                'reviews'
            )
        );
    }


    /*
     * =========================================
     * CREATE
     * =========================================
     */

    public function create(
        int $travelId
    ): View {

        $travel =
            $this->service
                ->getTravel(
                    $travelId
                );


        return view(
            'dashboard.reviews.create',
            compact(
                'travel'
            )
        );
    }


    /*
     * =========================================
     * STORE
     * =========================================
     */

    public function store(
        StoreReviewRequest $request,
        int $travelId
    ): RedirectResponse {

        $this->service
            ->create(
                $travelId,
                $request->validated()
            );


        return redirect()
            ->route(
                'admin.reviews.show',
                $travelId
            )
            ->with(
                'success',
                'Review berhasil ditambahkan.'
            );
    }


    /*
     * =========================================
     * EDIT
     * =========================================
     */

    public function edit(
        int $travelId,
        int $reviewId
    ): View {

        $travel =
            $this->service
                ->getTravel(
                    $travelId
                );


        $review =
            $this->service
                ->getReview(
                    $travelId,
                    $reviewId
                );


        return view(
            'dashboard.reviews.edit',
            compact(
                'travel',
                'review'
            )
        );
    }


    /*
     * =========================================
     * UPDATE
     * =========================================
     */

    public function update(
        UpdateReviewRequest $request,
        int $travelId,
        int $reviewId
    ): RedirectResponse {

        $this->service
            ->update(
                $travelId,
                $reviewId,
                $request->validated()
            );


        return redirect()
            ->route(
                'admin.reviews.show',
                $travelId
            )
            ->with(
                'success',
                'Review berhasil diperbarui.'
            );
    }


    /*
     * =========================================
     * DELETE
     * =========================================
     */

    public function destroy(
        int $travelId,
        int $reviewId
    ): RedirectResponse {

        $this->service
            ->delete(
                $travelId,
                $reviewId
            );


        return redirect()
            ->route(
                'admin.reviews.show',
                $travelId
            )
            ->with(
                'success',
                'Review berhasil dihapus.'
            );
    }
}
