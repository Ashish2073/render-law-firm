<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\PushNotificationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LawyerController;
use App\Http\Controllers\Admin\WelcomeMessageController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\CaseController;
use App\Http\Controllers\Admin\CaseMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\AuthController;

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });

// require _DIR_.'/auth.php';


Route::get('work-in-progress', function () {
    return view('workinprogress');
})->name('work-in-progress');

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::group([
    'prefix' => 'admin',
    'namespace' => 'App\Http\Controllers\Admin\Auth',
    'middleware' => ['web', 'guest'],
    'as' => 'admin.'
], function () {

    Route::get('/', 'AuthController@index')->name('login');
    Route::post('/', 'AuthController@login')->name('login.post');
});



Route::group([
    'prefix' => 'lawyer',
    'as' => 'lawyer.',
], function () {

    Route::get('/', function () {
        return view('lawyers.auth.login');
    })->name('detail.login');

    Route::get('registration', function () {
        return view('lawyers.auth.registration');
    });

    Route::get('otp-verification/{email?}', function () {
        return view('lawyers.auth.otpvarification');
    })->name('otp-verification');

    Route::post('/registration', [LawyerController::class, 'registration'])->name('registration');

    Route::post('/login', [LawyerController::class, 'login'])->name('login');
    Route::get('/logout', [LawyerController::class, 'logout'])->name('logout');

});

// 'middleware' => ['web','auth'],
Route::group([
    'prefix' => 'admin',
    'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => ['multipleauth'],
    'as' => 'admin.'
], function () {
    Route::get('/logout', 'Auth\AuthController@logout')->name('logout');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/weekly-enrolled-customer', [DashboardController::class, 'weeklyEnrollementCustomer'])->name('weekly.enrolled.customer');

    Route::get('/weekly-enrolled-lawyer', [DashboardController::class, 'weeklyEnrollementLawyer'])->name('weekly.enrolled.lawyer');

    // Practice Area routes
    Route::get('/practice-areas', 'PracticeAreaController@index')->name('practice-areas');
    Route::get('/practice-areas/create', 'PracticeAreaController@create')->name('practice-areas.create');
    Route::post('/practice-areas', 'PracticeAreaController@store')->name('practice-areas.store');
    Route::get('/practice-areas/{practiceArea}/edit', 'PracticeAreaController@edit')->name('practice-areas.edit');
    Route::put('/practice-areas/{practiceArea}', 'PracticeAreaController@update')->name('practice-areas.update');
    Route::delete('/practice-areas/{practiceArea}', 'PracticeAreaController@destroy')->name('practice-areas.destroy');
    Route::get('/practice-areas/search', 'PracticeAreaController@search')->name('practice-areas.search');

    // lawyer routes
    Route::get('/lawyers', 'LawyerController@index')->name('lawyers');
    Route::get('/lawyers/create', 'LawyerController@create')->name('lawyers.create');
    Route::post('/lawyer-status-update', [LawyerController::class, 'lawyerStatusUpdate'])->name('lawyer.statusupdate');

    Route::post('/lawyer/proficience-list', [LawyerController::class, 'proficienceListByParent'])->name('lawyer.proficiencelistbyparent');

    Route::post('/lawyer/edit', [LawyerController::class, 'editLawyer'])->name('lawyer.edit');

    Route::post('/lawyer-save', [LawyerController::class, 'lawyerSave'])->name('lawyer.save');

    Route::post('/lawyer/update', [LawyerController::class, 'lawyerUpdate'])->name('lawyer.update');

    Route::post('/lawyer/update/name', [LawyerController::class, 'lawyerUpdateName'])->name('update-lawyer-name');

    Route::post('/lawyer/update/email', [LawyerController::class, 'lawyerUpdateEmail'])->name('update-lawyer-email');

    Route::post('/lawyer/image/update', [LawyerController::class, 'lawyerImageUpdate'])->name('lawyer.image.update');

    Route::get('/get-feedbacks', [LawyerController::class, 'getFeedbacks'])->name('get-feedbacks');


    Route::post('/lawyer-proficience-save', [LawyerController::class, 'lawyerProficienceSave'])->name('lawyer.proficience-save');

    Route::post('/lawyer-proficience-update', [LawyerController::class, 'lawyerProficienceUpdate'])->name('lawyer.proficience-update');

    Route::post('/lawyer-proficience-edit', [LawyerController::class, 'lawyerProficienceEdit'])->name('lawyer.proficience-edit');

    Route::get('/lawyer-list', [LawyerController::class, 'lawyerlist'])->name('lawyer.list');



    Route::get('/lawyer/proficience', [LawyerController::class, 'proficienciesList'])->name('lawyers.proficience');

    Route::get('/lawyer/proficience', [LawyerController::class, 'proficienciesList'])->name('lawyers.proficience');

    Route::get('/push-notification/show', [PushNotificationController::class, 'notificationShow'])->name('notification.show');

    Route::post('/sendNotificaation', [PushNotificationController::class, 'sendNotificationAllUsers'])->name('notification.save');

    Route::get('/customer-list', [CustomerController::class, 'customerList'])->middleware('permission:customers_view')->name('customer.detail');

    Route::post('/customer-save', [CustomerController::class, 'customerSave'])->name('customer.save');

    Route::post('/customer-status-update', [CustomerController::class, 'customerStatusUpdate'])->name('customer.statusupdate')->middleware('permission:customer_status_edit');

    Route::get('/role-permission-list', [RolePermissionController::class, 'rolePermissionList'])->name('role-permission-list');

    Route::post('/role-permission-save', [RolePermissionController::class, 'rolePermissionSave'])->name('role-permission-save');

    Route::post('/role-permission-delete', [RolePermissionController::class, 'rolePermissionDelete'])->name('role-permission-delete');

    Route::post('/role-permission-edit', [RolePermissionController::class, 'rolePermissionEdit'])->name('role-permission-edit');







    // Route::post('/role-permission-update',[RolePermissionController::class,'rolePermissionUpdate'])->name('role-permission-update');

    Route::get("/user-list", [UserController::class, "userList"])->name("user-list");

    Route::post("/user-save", [UserController::class, "userSave"])->name("user-save");

    Route::post('/user-status-update', [UserController::class, 'userStatusUpdate'])->name('user.statusupdate');

    Route::post('/user-edit', [UserController::class, 'userEdit'])->name('user-edit');

    Route::post('/user-update', [UserController::class, 'userUpdate'])->name('user-update');

    Route::get('/welcome-message', [WelcomeMessageController::class, 'messageShow'])->name('welcome.message');

    Route::post('/welcome-message/save', [WelcomeMessageController::class, 'messageSave'])->name('welocome.message.save');

    Route::post('/welcome-message/image-update', [WelcomeMessageController::class, 'messageImageUpdate'])->name('welocome.message.image.update');

    Route::post('/welcome-message/update-welcome-message', [WelcomeMessageController::class, 'welcomeMessageTitleNameUpdate'])->name('welcome.update-welcome-message.title');

    Route::post('/welcome-message/update-welcome-message.content', [WelcomeMessageController::class, 'welcomeMessageContentUpdate'])->name('welcome.update-welcome-message.content');

    Route::post('/welcome-message-status-update', [WelcomeMessageController::class, 'statusUpdate'])->name('welcome.message.statusupdate');

    Route::get('/subscription/feature', [SubscriptionController::class, 'featureShow'])->name('subscription.feature');

    Route::post('/subscription/feature/save', [SubscriptionController::class, 'featureSave'])->name('subscription.feature.save');

    Route::post('/subscription/feature/update', [SubscriptionController::class, 'featureUpdate'])->name('subscription.feature.update');

    Route::post('/subscription/feature/status', [SubscriptionController::class, 'featureStatusUpdate'])->name('subscription.feature.status');

    Route::get('/faq/category', [FaqController::class, 'featureShow'])->name('faq.category');

    Route::post('/faq/feature/save', [FaqController::class, 'featureSave'])->name('faq.category.save');

    Route::post('/faq/feature/update', [FaqController::class, 'featureUpdate'])->name('faq.category.update');

    Route::post('/faq/feature/status', [FaqController::class, 'featureStatusUpdate'])->name('faq.category.status');

    Route::get('/faq/question', [FaqController::class, 'faqQuestionShow'])->name('faq.question');

    Route::post('/text-image-upload', [FaqController::class, 'textareaimageupload'])->name('text.image.upload');

    Route::post('/faq/save', [FaqController::class, 'faqSave'])->name('faq.save');

    Route::post('faq/status/update', [FaqController::class, 'faqStatusChange'])->name('faq.status');

    Route::post('faq/updateCategory', [FaqController::class, 'updateCategory'])->name('faq.updateCategory');
    Route::post('faq/update/question', [FaqController::class, 'updateQuestion'])->name('faq.updateQuestion');
    Route::post('faq/update/answer', [FaqController::class, 'updateAnswer'])->name('faq.updateAnswer');


    Route::get('cuatomer/cases', [CaseController::class, 'index'])->name('customer-cases');
    Route::post('lawyer/cases-assign', [CaseController::class, 'lawyerAssign'])->name('lawyer-cases-assign');

    Route::post('lawyer/cases-dissiociate', [CaseController::class, 'lawyerDissiociate'])->name('lawyer-dissiociate-assign');

    Route::get('case/{id}/message', [CaseMessageController::class, 'index'])->name('case-message');

    Route::get('case/message/all/{id}', [CaseMessageController::class, 'showMessages'])->name('messages-all');

    Route::post('case/message/store', [CaseMessageController::class, 'store'])->name('case-message-store');


});


Route::get('/check-notification', function () {
    return view('checktest');
});


////Notification Testing////////////////
Route::get('/send-notification', function () {
    return view('send_notification');
});

Route::post('/send-notification', [NotificationController::class, 'send'])->name('send.notification');