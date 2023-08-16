<?php

use App\Http\Controllers\API\User\Accounting\AccountItemAPIController;
use App\Http\Controllers\API\User\Accounting\CurrencyAPIController;
use App\Http\Controllers\API\User\Accounting\JournalAPIController;
use App\Http\Controllers\API\User\Auth\AuthAPIController;
use App\Http\Controllers\API\User\CountryAPIController;
use App\Http\Controllers\API\User\EducationAPIController;
use App\Http\Controllers\API\User\ExternalOfficeTransactionAPIController;
use App\Http\Controllers\API\User\Housemaid\ApplicationAPIController;
use App\Http\Controllers\API\User\Housemaid\ApplicationExternalOfficeTransactionAPIController;
use App\Http\Controllers\API\User\Housemaid\ApplicationStatus\ApplicationArrivalAPIController;
use App\Http\Controllers\API\User\Housemaid\ApplicationStatus\ApplicationDeliverAPIController;
use App\Http\Controllers\API\User\Housemaid\ApplicationStatus\ApplicationDeportationAPIController;
use App\Http\Controllers\API\User\Housemaid\ApplicationStatus\ApplicationExpectedArrivalAPIController;
use App\Http\Controllers\API\User\Housemaid\ApplicationStatus\ApplicationResellAPIController;
use App\Http\Controllers\API\User\Housemaid\ApplicationStatus\ApplicationReservationAPIController;
use App\Http\Controllers\API\User\Housemaid\ApplicationStatus\ApplicationVisaAPIController;
use App\Http\Controllers\API\User\JobAPIController;
use App\Http\Controllers\API\User\LanguageAPIController;
use App\Http\Controllers\API\User\Office\ExternalOfficeAPIController;
use App\Http\Controllers\API\User\Office\InternalOfficeAPIController;
use App\Http\Controllers\API\User\ProfileAPIController;
use App\Http\Controllers\API\User\ReligionAPIController;
use App\Http\Controllers\API\User\SponsorAPIController;
use App\Http\Controllers\API\User\UserAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('test', function () {

    $token = Request::create('/api/users/auth/login', 'post', [
        "email" => "admin@admin.com",
        "password" => "123456",
    ]);
    $response = Route::dispatch($token);
    return $token;
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'users'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthAPIController::class, 'login']);
        Route::post('register', [AuthAPIController::class, 'register']);
        Route::post('logout', [AuthAPIController::class, 'logout']);
    });


    Route::middleware('auth:sanctum')->group(function () {

        Route::apiResource('languages', LanguageAPIController::class);
        Route::apiResource('countries', CountryAPIController::class);
        Route::apiResource('educations', EducationAPIController::class);
        Route::apiResource('religions', ReligionAPIController::class);
        Route::apiResource('jobs', JobAPIController::class);
        Route::apiResource('external_office_transactions', ExternalOfficeTransactionAPIController::class);


        ### Start Accounting ###
        Route::group(['prefix' => 'accounting'], function () {
            Route::apiResource('account_items', AccountItemAPIController::class);
            Route::apiResource('currencies', CurrencyAPIController::class);
            Route::apiResource('journals', JournalAPIController::class);
        });
        ### End Accounting ###


        ### Start Offices ###
        Route::group(['prefix' => 'offices'], function () {

            ### Start Internal Offices ###
            Route::get('internal_offices/generate_code/{name}', [InternalOfficeAPIController::class, 'generateCode']);
            Route::apiResource('internal_offices', InternalOfficeAPIController::class);
            ### End Internal Offices ###

            ### Start External Offices ###
            Route::get('external_offices/generate_code/{name}', [ExternalOfficeAPIController::class, 'generateCode']);
            Route::apiResource('external_offices', ExternalOfficeAPIController::class);

            ### Start External Offices ###

        });
        ### End Offices ###


        ### Start Sponsor ###
        Route::apiResource('sponsors', SponsorAPIController::class);

        ### End Sponsor ###

        ### Start Application ###
//        Route::post('applications/change_status/{application_id}', [ApplicationAPIController::class, 'change_status']); //for test
        Route::get('applications/{application_id}/notes', [ApplicationAPIController::class, 'notes']);
        Route::get('applications/internal_offices/{external_office_id}', [ApplicationAPIController::class, 'internalOfficesByExternalOffice']);
        Route::get('applications/generate_code/{external_office_id}', [ApplicationAPIController::class, 'generateCode']);
        Route::apiResource('applications', ApplicationAPIController::class);
        Route::apiResource('application_e_office_transactions', ApplicationExternalOfficeTransactionAPIController::class);
        ### End Application ###

        ### Start Application Reservations ###
        Route::apiResource('application_reservations', ApplicationReservationAPIController::class)->except(['update']);
        ### End Application Reservations ###

        ### Start Application Visas ###
        Route::apiResource('application_visas', ApplicationVisaAPIController::class);
        ### End Application Visas ###

        ## start Expected ApplicationArrival ##

        Route::apiResource('application_expected_arrival', ApplicationExpectedArrivalAPIController::class);
        Route::apiResource('application_arrival', ApplicationArrivalAPIController::class);
        Route::apiresource('application_deportation', ApplicationDeportationAPIController::class);
        Route::apiresource('application_deliver', ApplicationDeliverAPIController::class);
        Route::apiresource('application_resell', ApplicationResellAPIController::class);


        ## end Expected ApplicationArrival ##


        ### Start User ###
        Route::apiResource('admins', UserAPIController::class); // TODO check update photo in for user in update method
        ### End User ###

        ### Start Profile User ###
        Route::prefix('profile')->group(function () {
            Route::get('me', [ProfileAPIController::class, 'me']);
            Route::post('update', [ProfileAPIController::class, 'update']);
        });
        ### End Profile User ###

    });


});
