<?php

use CardzApp\Api\Account\Presentation\Controllers\GetOwnUserController;
use CardzApp\Api\Account\Presentation\Controllers\RegisterUserController;
use CardzApp\Api\Account\Presentation\Controllers\UpdateOwnUserController;
use CardzApp\Api\Shared\Presentation\Routes;

Route::prefix(Routes::URL_PREFIX)->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/account/users')->group(function () {
        Route::post('/')
            ->name(Routes::ACCOUNT_REGISTER_USER_ACTION)->uses(RegisterUserController::class);
    });

    Route::prefix('/account/user')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::get('/')
            ->name(Routes::ACCOUNT_GET_OWN_USER_ACTION)->uses(GetOwnUserController::class);
        Route::patch('/')
            ->name(Routes::ACCOUNT_UPDATE_OWN_USER_ACTION)->uses(UpdateOwnUserController::class);
    });
});
