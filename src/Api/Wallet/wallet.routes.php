<?php

use CardzApp\Api\Shared\Routes;
use CardzApp\Api\Wallet\Controllers\GetOwnCardController;
use CardzApp\Api\Wallet\Controllers\GetOwnCardsController;

Route::prefix(Routes::URL_PREFIX . '/wallet')->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::get('/cards')
            ->name(Routes::WALLET_GET_OWN_CARDS)->uses(GetOwnCardsController::class);
        Route::get('/card/id/{card}')
            ->name(Routes::WALLET_GET_OWN_CARD)->uses(GetOwnCardController::class);
    });
});
