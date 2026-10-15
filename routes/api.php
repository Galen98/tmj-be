<?php

use App\Http\Controllers\Message\CorporateMessageController;
use App\Http\Controllers\Message\PersonalMessageController;
use App\Http\Controllers\Setting\SettingParameterController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\PointOfInterestController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\BackgroundController;
use App\Http\Controllers\Api\VoucherController;
use App\Http\Controllers\Api\FootTagController;
use App\Http\Controllers\Api\UserTokenController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\EmailCustomerController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\CorporateRequestController;
use App\Http\Controllers\Api\TravelController;
use App\Http\Controllers\Api\ParameterGlobalController;
use App\Http\Controllers\Api\DateAvailabilityController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//notification
Route::post('/send-notification', [\App\Http\Controllers\Notification\NotificationController::class, 'sendNotification']);
Route::get('/notifications', [\App\Http\Controllers\Notification\NotificationController::class, 'getAllNotifications']);
Route::put('/notifications/{id}/mark-as-read', [\App\Http\Controllers\Notification\NotificationController::class, 'checkIsRead']);
Route::get('/notifications/unread-count', [\App\Http\Controllers\Notification\NotificationController::class, 'countUnreadNotifications']);
Route::put('/notifications/mark-all-as-read', [\App\Http\Controllers\Notification\NotificationController::class, 'markAllAsRead']);

//setting parameter
Route::get('/parameters', [SettingParameterController::class, 'getAllParameters']);
Route::get('/parameters/{key}', [SettingParameterController::class, 'getParametersByKey']);
Route::get('/parameters/search/{key}', [SettingParameterController::class, 'searchParametersByKey']);
Route::put('/parameters/{key}', [SettingParameterController::class, 'updateParameter']);

//corporate message
Route::post('/corporate-messages', [CorporateMessageController::class, 'sendCorporateMessage']);
Route::get('/corporate-messages', [CorporateMessageController::class, 'getCorporateMessages']);
Route::get('/corporate-messages/{id}', [CorporateMessageController::class, 'getCorporateMessageById']);
Route::delete('/corporate-messages/{id}', [CorporateMessageController::class, 'deleteCorporateMessage']);

//personal message
Route::post('/personal-messages', [PersonalMessageController::class, 'sendPersonalMessage']);
Route::post('/personal-messages/{id}/admin-send', [PersonalMessageController::class, 'adminSendPersonalMessage']);
Route::get('/personal-messages', [PersonalMessageController::class, 'getPersonalMessages']);
Route::get('/personal-messages/{id}', [PersonalMessageController::class, 'getPersonalMessagesById']);
Route::delete('/personal-messages/{id}',[PersonalMessageController::class, 'deletePersonalMessage']);

//city
Route::prefix('cities')->group(function () {

    Route::get(
        '/',
        [CityController::class, 'index']
    );

    Route::get(
        '/{slug}',
        [CityController::class, 'show']
    );

});

//tracking users


//analytics users


//chat users


//Logging

//background
Route::get(
    '/backgrounds',
    [
        BackgroundController::class,
        'index',
    ]
);

//tags
Route::get(
    '/tags',
    [
        TagController::class,
        'index',
    ]
);

//Region
Route::prefix('regions')->group(function () {

    Route::get(
        '/provinces',
        [RegionController::class, 'provinces']
    );

    Route::get(
        '/regencies/{provinceCode}',
        [RegionController::class, 'regencies']
    );

});

//point-of-interest
Route::prefix('point-of-interests')
    ->group(function () {

        Route::get(
            '/',
            [
                PointOfInterestController::class,
                'index',
            ]
        );

        Route::get(
            '/{slug}',
            [
                PointOfInterestController::class,
                'show',
            ]
        );

});

//vouchers
Route::get(
    '/vouchers',
    [
        VoucherController::class,
        'index',
    ]
);

//foottags
Route::get(
    '/foot-tags',
    [
        FootTagController::class,
        'index',
    ]
);

//user token
Route::post(
    '/user-token',
    [
        UserTokenController::class,
        'store',
    ]
);

//analytics
Route::post(
    '/analytics/page-view',
    [
        AnalyticsController::class,
        'store',
    ]
);

//schedulers


//email customer
Route::post(
    '/email-customers',
    [
        EmailCustomerController::class,
        'store',
    ]
);

//contact us
Route::post(
    '/contact-us',
    [
        ContactUsController::class,
        'store',
    ]
)->middleware(
    'throttle:5,1'
);

//search
Route::get(
    '/search/suggestions',
    [
        SearchController::class,
        'suggestions',
    ]
);


//Corporate Request
Route::post(
    '/corporate-requests',
    [
        CorporateRequestController::class,
        'store',
    ]
);


//travel
Route::prefix('travels')->group(function () {
    Route::get(
        '/',
        [TravelController::class, 'index']
    );

    Route::get(
        '/{slug}',
        [TravelController::class, 'show']
    );
});


//parameter global
Route::get(
    '/parameter-global/{name}',
    [ParameterGlobalController::class, 'show']
);

//date avail
Route::get(
    '/travel-options/{option}/date-availabilities',
    [DateAvailabilityController::class, 'index']
);
