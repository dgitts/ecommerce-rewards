<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin')->group(function () {
        // Admin Routes
        Route::group(['middleware' => ['admin']], function () {

            // Timesheet Routes
            Route::get('timesheets', 'TimesheetController@index')->defaults('_config',[
                'view' => 'timesheets.index'
            ])->name('admin.timesheets.index');

            Route::get('timesheets/create', 'TimesheetController@create')->defaults('_config',[
                'view' => 'timesheets.create'
            ])->name('admin.timesheets.create');

            Route::post('timesheets/create', 'TimesheetController@store')->defaults('_config',[
                'redirect' => 'admin.timesheets.index'
            ])->name('admin.timesheet.store');

//            Route::get('timesheets/edit/{id}', 'TimesheetController@edit')->defaults('_config',[
//                'view' => 'timesheets.edit'
//            ])->name('admin.timesheets.edit');
//
//            Route::put('timesheets/edit/{id}', 'TimesheetController@update')->defaults('_config',[
//                'redirect' => 'admin.timesheets.index'
//            ])->name('admin.timesheets.update');
//
//            Route::post('timesheets/delete/{id}', 'Webkul\Admin\Http\Controllers\Customer\CustomerGroupController@destroy')->name('admin.timesheets.delete');

            // Points Routes
            Route::get('customers/{id}/points', 'PointsController@index')->defaults('_config', [
                'view' => 'admin::customers.points.index',
                'type' => 'timesheets'
            ])->name('admin.points.index');

            Route::get('customers/{id}/point-modifications', 'PointsController@index')->defaults('_config', [
                'view' => 'admin::customers.points.index',
                'type' => 'point-modifications'
            ])->name('admin.points.modifications.index');

            Route::get('customers/{id}/points/add', 'PointsController@create')->defaults('_config',[
                'view' => 'admin::customers.points.create',
                'add_deduct' => 'Add'
            ])->name('admin.points.add');

            Route::get('customers/{id}/points/deduct', 'PointsController@create')->defaults('_config',[
                'view' => 'admin::customers.points.create',
                'add_deduct' => 'Deduct'
            ])->name('admin.points.deduct');

            Route::post('customers/{id}/points/create', 'PointsController@store')->defaults('_config',[
                'redirect' => 'admin.customer.points.index'
            ])->name('admin.points.store');
        });
    });
});

Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {
//customer routes starts here
    Route::prefix('customer')->group(function () {
        // Password Expired Form Show
        Route::get('/password/expired', 'ExpiredPasswordController@create')->defaults('_config', [
            'view' => 'customers.signup.password-expired'
        ])->name('customer.password-expired.create');

        // Forgot Password Form Store
        Route::post('/password-expired', 'ExpiredPasswordController@store')->name('customer.password-expired.store');
    });
});