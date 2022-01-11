<?php

use CardzApp\Api\Account\Controllers\GetOwnUserController;
use CardzApp\Api\Account\Controllers\RegisterUserController;
use CardzApp\Api\Account\Controllers\UpdateOwnUserController;
use CardzApp\Api\Shared\Routes;

Route::prefix(Routes::URL_PREFIX . '/account')->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/users')->group(function () {
        Route::post('/')
            ->name(Routes::ACCOUNT_REGISTER_USER)->uses(RegisterUserController::class);
    });

    Route::prefix('/user')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::get('/')
            ->name(Routes::ACCOUNT_GET_OWN_USER)->uses(GetOwnUserController::class);
        Route::patch('/')
            ->name(Routes::ACCOUNT_UPDATE_OWN_USER)->uses(UpdateOwnUserController::class);
    });
});
