<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\PointOfInterestController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\BackgroundController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\ParameterGlobalController;
use App\Http\Controllers\Admin\EmailCustomerController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\CorporateRequestController;
use App\Http\Controllers\Admin\TravelController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\DateAvailabilityController;
use App\Http\Controllers\Admin\DashboardAnalyticsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware([
    'auth',
])->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource(
            'cities',
            CityController::class
        )->except([
            'show',
        ]);


        Route::resource(
            'point-of-interests',
            PointOfInterestController::class
        )->except([
            'show',
        ]);

         Route::get(
            '/tags',
            [
                TagController::class,
                'index',
            ]
        )->name('tags.index');


        Route::patch(
            '/tags/{id}/status',
            [
                TagController::class,
                'updateStatus',
            ]
        )->name('tags.status');

         Route::resource(
            'backgrounds',
            BackgroundController::class
        )->except([
            'show',
        ]);

        Route::patch(
            '/backgrounds/{id}/status',
            [
                BackgroundController::class,
                'updateStatus',
            ]
        )->name(
            'backgrounds.status'
        );

        Route::resource(
            'vouchers',
            VoucherController::class
        )->except([
            'show',
        ]);

        Route::get(
        '/parameter-global',
        [
            ParameterGlobalController::class,
            'index',
        ]
        )->name(
            'parameter-global.index'
        );


        Route::put(
            '/parameter-global/{parameterGlobal}',
            [
                ParameterGlobalController::class,
                'update',
            ]
        )->name(
            'parameter-global.update'
        );

         Route::get(
        '/email-customers',
        [
            EmailCustomerController::class,
            'index',
        ]
    )->name(
        'email-customers.index'
    );


    Route::patch(
        '/email-customers/{emailCustomer}/status',
        [
            EmailCustomerController::class,
            'updateStatus',
        ]
    )->name(
        'email-customers.status'
    );

            Route::get(
            '/contact-us',
            [
                ContactUsController::class,
                'index',
            ]
        )->name(
            'contact-us.index'
        );


        Route::get(
            '/contact-us/{contact}',
            [
                ContactUsController::class,
                'show',
            ]
        )->name(
            'contact-us.show'
        );


        Route::post(
            '/contact-us/{contact}/reply',
            [
                ContactUsController::class,
                'reply',
            ]
        )->name(
            'contact-us.reply'
        );

        Route::get(
            '/corporate-requests',
            [
                CorporateRequestController::class,
                'index',
            ]
        )->name(
            'corporate-requests.index'
        );


        Route::get(
            '/corporate-requests/{corporateRequest}',
            [
                CorporateRequestController::class,
                'show',
            ]
        )->name(
            'corporate-requests.show'
        );

        Route::resource('travels', TravelController::class);

        Route::prefix('reviews')
            ->name('reviews.')
            ->group(function () {

                Route::get(
                    '/',
                    [ReviewController::class, 'index']
                )->name('index');


                Route::get(
                    '/travel/{travelId}',
                    [ReviewController::class, 'show']
                )->name('show');


                Route::get(
                    '/travel/{travelId}/create',
                    [ReviewController::class, 'create']
                )->name('create');


                Route::post(
                    '/travel/{travelId}',
                    [ReviewController::class, 'store']
                )->name('store');


                Route::get(
                    '/travel/{travelId}/{reviewId}/edit',
                    [ReviewController::class, 'edit']
                )->name('edit');


                Route::put(
                    '/travel/{travelId}/{reviewId}',
                    [ReviewController::class, 'update']
                )->name('update');


                Route::delete(
                    '/travel/{travelId}/{reviewId}',
                    [ReviewController::class, 'destroy']
                )->name('destroy');

            });

            Route::prefix('date-availabilities')
                ->name('date-availabilities.')
                ->group(function () {

                    Route::get('/', [DateAvailabilityController::class, 'index'])
                        ->name('index');

                    Route::get('/travels/{travel}', [DateAvailabilityController::class, 'options'])
                        ->name('options');

                    Route::get('/options/{option}', [DateAvailabilityController::class, 'manage'])
                        ->name('manage');

                    Route::post('/options/{option}', [DateAvailabilityController::class, 'store'])
                        ->name('store');

                    Route::put('/{availability}', [DateAvailabilityController::class, 'update'])
                        ->name('update');

                    Route::delete('/{availability}', [DateAvailabilityController::class, 'destroy'])
                        ->name('destroy');
                });

                Route::get(
                    '/dashboard/analytics',
                    [DashboardAnalyticsController::class, 'index']
                )->name('dashboard.analytics');
});

require __DIR__.'/auth.php';
