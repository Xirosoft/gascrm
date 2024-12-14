<?php

use App\Http\Controllers\NewDevPageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Test Route::START
Route::group(['prefix' => 'command'], function () {
    Route::get('clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        dd("All clear!");
    });

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        dd("Added!");
    });

    Route::get('/down', function () {
        Artisan::call('down');
        dd("maintenance mode Enabled!");
    });

    Route::get('/up', function () {
        Artisan::call('up');
        dd("maintenance mode Disabled!");
    });
});
//Test Route::END

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('home');

Auth::routes(['verify' => true]);

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'verified']], function () {    
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::post('profile', 'ProfileController@update');
    Route::get('profile/password', 'ProfileController@password')->name('profile.password');
    Route::post('profile/password', 'ProfileController@passwordUpdate');

    Route::post('user/bulk-update', 'UserController@bulkUpdate')->name('user.bulk-update');
    Route::resource('user', 'UserController');
    
    Route::post('lead/follow/{leadId}', 'LeadController@follow')->name('lead.follow');
    Route::post('lead/owner-change/{leadId}', 'LeadController@ownerChange')->name('lead.owner-change');
    Route::post('lead/convert/{leadId}', 'LeadController@convert')->name('lead.convert');
    Route::post('lead/status-change', 'LeadController@statusChange')->name('lead.status-change');
    Route::post('lead/bulk-update', 'LeadController@bulkUpdate')->name('lead.bulk-update');
    Route::get('lead/printable-view/{leadId}', 'LeadController@printable')->name('lead.printable');
    Route::resource('lead', 'LeadController');
    
    Route::post('account/follow/{accountId}', 'AccountController@follow')->name('account.follow');
    Route::post('account/owner-change/{accountId}', 'AccountController@ownerChange')->name('account.owner-change');
    Route::post('account/bulk-update', 'AccountController@bulkUpdate')->name('account.bulk-update');
    Route::get('account/printable-view/{accountId}', 'AccountController@printable')->name('account.printable');
    Route::resource('account', 'AccountController');
    
    Route::post('contact/follow/{contactId}', 'ContactController@follow')->name('contact.follow');
    Route::post('contact/owner-change/{contactId}', 'ContactController@ownerChange')->name('contact.owner-change');
    Route::post('contact/bulk-update', 'ContactController@bulkUpdate')->name('contact.bulk-update');
    Route::get('contact/printable-view/{contactId}', 'ContactController@printable')->name('contact.printable');
    Route::resource('contact', 'ContactController');

    Route::post('task/bulk-update', 'TaskController@bulkUpdate')->name('task.bulk-update');
    Route::post('task/change/{taskId}', 'TaskController@change')->name('task.change');
    Route::get('task/delegated', 'TaskController@delegated')->name('task.delegated');
    Route::get('task/today', 'TaskController@today')->name('task.today');
    Route::resource('task', 'TaskController');

    Route::post('event/bulk-update', 'EventController@bulkUpdate')->name('event.bulk-update');
    Route::get('event/calender', 'EventController@calender')->name('event.calender');
    Route::post('event/calender-jax', 'EventController@calenderAjax')->name('event.calender-ajax');
    Route::resource('event', 'EventController');
    
    Route::resource('email', 'EmailController')->only('index', 'store');
    
    Route::get('note/all', 'NoteController@all')->name('note.all');
    Route::resource('note', 'NoteController')->only('index', 'store');
    
    Route::get('file/all', 'FileController@all')->name('file.all');
    Route::resource('file', 'FileController')->only('index', 'store');

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::post('salutation/bulk-update', 'Setting\SalutationController@bulkUpdate')->name('salutation.bulk-update');
        Route::post('salutation/sortable', 'Setting\SalutationController@sortable')->name('salutation.sortable');
        Route::resource('salutation', 'Setting\SalutationController')->only('index', 'store', 'update', 'destroy');

        Route::post('industry/bulk-update', 'Setting\IndustryController@bulkUpdate')->name('industry.bulk-update');
        Route::post('industry/sortable', 'Setting\IndustryController@sortable')->name('industry.sortable');
        Route::resource('industry', 'Setting\IndustryController')->only('index', 'store', 'update', 'destroy');

        Route::post('lead-status/bulk-update', 'Setting\LeadStatusController@bulkUpdate')->name('lead-status.bulk-update');
        Route::post('lead-status/sortable', 'Setting\LeadStatusController@sortable')->name('lead-status.sortable');
        Route::resource('lead-status', 'Setting\LeadStatusController')->only('index', 'store', 'update', 'destroy');

        Route::post('rating/bulk-update', 'Setting\RatingController@bulkUpdate')->name('rating.bulk-update');
        Route::post('rating/sortable', 'Setting\RatingController@sortable')->name('rating.sortable');
        Route::resource('rating', 'Setting\RatingController')->only('index', 'store', 'update', 'destroy');

        Route::post('source/bulk-update', 'Setting\SourceController@bulkUpdate')->name('source.bulk-update');
        Route::post('source/sortable', 'Setting\SourceController@sortable')->name('source.sortable');
        Route::resource('source', 'Setting\SourceController')->only('index', 'store', 'update', 'destroy');

        Route::post('account-type/bulk-update', 'Setting\AccountTypeController@bulkUpdate')->name('account-type.bulk-update');
        Route::post('account-type/sortable', 'Setting\AccountTypeController@sortable')->name('account-type.sortable');
        Route::resource('account-type', 'Setting\AccountTypeController')->only('index', 'store', 'update', 'destroy');
    });

    
    Route::get('api-options','Api\ApiController@options')->name('api-options');
});




Route::get('new-dev', [NewDevPageController::class, 'index'])->name('new-dev');