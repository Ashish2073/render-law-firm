<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\AuthController;
use App\Http\Controllers\Api\Customer\CustomerNotificationController;
use App\Http\Controllers\Api\LawyerController;
use App\Http\Controllers\Api\CountryStateCityController;
use App\Http\Controllers\Api\CaseController;



Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});






Route::get('country-list/{search_term?}',[CountryStateCityController::class,'getCountry']);
Route::get('state-list/{countryid?}/{search_term?}',[CountryStateCityController::class,'getState']);
Route::get('city-list/{countryid?}/{stateid?}/{search_term?}',[CountryStateCityController::class,'getCity']);

Route::prefix('customer')->group(function () {
    Route::post('/registration', [AuthController::class, 'customerRegistertion']);

    Route::post('/otpvarification', [AuthController::class, 'customerOtpVarification']);

    Route::post('/resendotp', [AuthController::class, 'resendOtp']);

    Route::post('/login', [AuthController::class, 'customerLogin']);

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    Route::post('/resetPassword', [AuthController::class, 'resetPassword']);

    Route::post('/save-customer-fcm-token', [CustomerNotificationController::class, 'storeCustomerFcmToken']);

    Route::get('login/google', [AuthController::class, 'redirectToGoogle']);
    Route::post('login/socialmedia/callback', [AuthController::class, 'handleSocialMediaCallback']);

    Route::post('/password-otp-varification',[AuthController::class,'passwordOtpVarification']);
    Route::get('/welcome-message',[CustomerNotificationController::class,'customerWelcomeMessage']);
    Route::get('/faq', [CustomerNotificationController::class, 'faqList']);


});

Route::prefix('customer')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/customer-detail', function (Request $request) {
        return response()->json(['data'=>$request->user(),'profile_image_url'=>asset("customer_image/".$request->user()->profile_image)]);
    });
    Route::post('/logout', [AuthController::class, 'customerLogout']);
    Route::get('/lawyers-detail-list',[LawyerController::class,'getLawyerDetailList']);
    Route::get('/lawyer-review/{id}',[LawyerController::class,'getLawyerReviewList']);

    Route::post('/lawyer-review-save',[LawyerController::class,'lawyerReviewSave']);

    Route::get('/lawyer-search/{serach_term?}',[LawyerController::class,'lawyerSearchList']);

    Route::get('/lawyer-proficience-list/{parent_id?}',[LawyerController::class,'legalProficienciesList']);

    Route::post('/bookmark-save',[CustomerNotificationController::class,'customerBookmarkSave']);
    Route::get('/bookmark/{customerid?}',[CustomerNotificationController::class,'customerBookmarklist']);

    Route::post('/bookmark-lawyer-remove',[CustomerNotificationController::class,'customerBookmarkRemove']);



    Route::post('/editProfile',[AuthController::class,'editProfile']);

    Route::get('/lawyer-suggestions/{serach_term?}', [LawyerController::class, 'getLawyerSuggestions']);

    Route::get('lawyer-details/{lawyer_id?}', [LawyerController::class,'getLawyerDetailsById']);

    Route::post('/case-filed-customer-detail-save',[CaseController::class,'caseFieldCustomerProfileDetailSave']);

    Route::post('/case-detail-save',[CaseController::class,'caseDetailSaveByCustomer']);

    Route::post('/case-detail-update',[CaseController::class,'caseFieldCustomerProfileDetailUpdate']);

    Route::get('/accuser-list/{customer_id?}',[CaseController::class,'accuserList']);

    Route::get('/case-file-detail/{customer_id?}',[CaseController::class,'caseFile']);

    // Route::get('/lawyer-filter',[LawyerController::class,'lawyerFilterList']);

});

