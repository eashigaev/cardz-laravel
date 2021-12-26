<?php

use CardzApp\Api\Application\Actions;
use CardzApp\Api\Presentation\Business\Controllers\FoundCompanyController;
use CardzApp\Api\Presentation\Business\Controllers\GetCompaniesController;
use CardzApp\Api\Presentation\Business\Controllers\GetCompanyController;
use CardzApp\Api\Presentation\Business\Controllers\UpdateCompanyController;
use CardzApp\Api\Presentation\Routes;

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
