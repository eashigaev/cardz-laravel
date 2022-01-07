<?php

use CardzApp\Api\Business\Presentation\Controllers\FoundCompanyController;
use CardzApp\Api\Business\Presentation\Controllers\GetCompaniesController;
use CardzApp\Api\Business\Presentation\Controllers\GetCompanyController;
use CardzApp\Api\Business\Presentation\Controllers\UpdateCompanyController;
use CardzApp\Api\Shared\Presentation\Routes;

Route::prefix(Routes::URL_PREFIX . '/business')->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/companies')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Routes::BUSINESS_FOUND_COMPANY)->uses(FoundCompanyController::class);
        Route::get('/')
            ->name(Routes::BUSINESS_GET_COMPANIES)->uses(GetCompaniesController::class);
    });

    Route::prefix('/company')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::patch('/id/{company}')
            ->name(Routes::BUSINESS_UPDATE_COMPANY)->uses(UpdateCompanyController::class);
        Route::get('/id/{company}')
            ->name(Routes::BUSINESS_GET_COMPANY)->uses(GetCompanyController::class);
    });
});
