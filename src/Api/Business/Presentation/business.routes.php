<?php

use CardzApp\Api\Business\Presentation\Controllers\FoundCompanyController;
use CardzApp\Api\Business\Presentation\Controllers\GetCompaniesController;
use CardzApp\Api\Business\Presentation\Controllers\GetCompanyController;
use CardzApp\Api\Business\Presentation\Controllers\UpdateCompanyController;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;

Route::prefix(Routes::URL_PREFIX)->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/business/companies')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Actions::BUSINESS_FOUND_COMPANY)->uses(FoundCompanyController::class);
        Route::get('/')
            ->name(Actions::BUSINESS_GET_COMPANIES)->uses(GetCompaniesController::class);
    });

    Route::prefix('/business/company')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::patch('/id/{company}')
            ->name(Actions::BUSINESS_UPDATE_COMPANY)->uses(UpdateCompanyController::class);
        Route::get('/id/{company}')
            ->name(Actions::BUSINESS_GET_COMPANY)->uses(GetCompanyController::class);
    });
});
