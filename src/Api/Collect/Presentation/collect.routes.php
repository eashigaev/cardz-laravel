<?php

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use App\Models\Collect\Task;
use App\Models\Company;
use CardzApp\Api\Collect\Presentation\Controllers\Card\CancelCardController;
use CardzApp\Api\Collect\Presentation\Controllers\Card\IssueCardController;
use CardzApp\Api\Collect\Presentation\Controllers\Card\RejectCardController;
use CardzApp\Api\Collect\Presentation\Controllers\Card\UpdateCardController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\AddProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\GetProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\GetProgramsController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\UpdateProgramActiveController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\UpdateProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\Task\AddTaskController;
use CardzApp\Api\Collect\Presentation\Controllers\Task\GetTaskController;
use CardzApp\Api\Collect\Presentation\Controllers\Task\GetTasksController;
use CardzApp\Api\Collect\Presentation\Controllers\Task\UpdateTaskActiveController;
use CardzApp\Api\Collect\Presentation\Controllers\Task\UpdateTaskController;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Codderz\YokoLite\Application\Authorization\Middleware\Authorize;

Route::prefix(Routes::URL_PREFIX . '/collect')->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/company/id/{company}/programs')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Routes::COLLECT_ADD_PROGRAM)->uses(AddProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_ADD_PROGRAM, ['company' => Company::class]));
        Route::get('/')
            ->name(Routes::COLLECT_GET_PROGRAMS)->uses(GetProgramsController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAMS, ['company' => Company::class]));
    });

    Route::prefix('/program/id/{program}')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::patch('/')
            ->name(Routes::COLLECT_UPDATE_PROGRAM)->uses(UpdateProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM, ['program' => Program::class]));
        Route::get('/')
            ->name(Routes::COLLECT_GET_PROGRAM)->uses(GetProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAM, ['program' => Program::class]));
        Route::patch('/active')
            ->name(Routes::COLLECT_UPDATE_PROGRAM_ACTIVE)->uses(UpdateProgramActiveController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM_ACTIVE, ['program' => Program::class]));
    });

    Route::prefix('/program/id/{program}/tasks')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Routes::COLLECT_ADD_TASK)->uses(AddTaskController::class)
            ->middleware(Authorize::for(Actions::COLLECT_ADD_TASK, ['program' => Program::class]));
        Route::get('/')
            ->name(Routes::COLLECT_GET_TASKS)->uses(GetTasksController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_TASKS, ['program' => Program::class]));
    });

    Route::prefix('/task/id/{task}')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::patch('/')
            ->name(Routes::COLLECT_UPDATE_TASK)->uses(UpdateTaskController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_TASK, ['task' => Task::class]));
        Route::get('/')
            ->name(Routes::COLLECT_GET_TASK)->uses(GetTaskController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_TASK, ['task' => Task::class]));
        Route::patch('/active')
            ->name(Routes::COLLECT_UPDATE_TASK_ACTIVE)->uses(UpdateTaskActiveController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_TASK_ACTIVE, ['task' => Task::class]));
    });

    Route::prefix('/program/id/{program}/cards')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Routes::COLLECT_ISSUE_CARD)->uses(IssueCardController::class)
            ->middleware(Authorize::for(Actions::COLLECT_ISSUE_CARD, ['program' => Program::class]));
//        Route::get('/')
//            ->name(Routes::COLLECT_GET_PROGRAM_TASKS)->uses(GetTasksController::class)
//            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAM_TASKS, ['program' => Program::class]));
    });

    Route::prefix('/card/id/{card}')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::patch('/')
            ->name(Routes::COLLECT_UPDATE_CARD)->uses(UpdateCardController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_CARD, ['card' => Card::class]));
        Route::patch('/reject')
            ->name(Routes::COLLECT_REJECT_CARD)->uses(RejectCardController::class)
            ->middleware(Authorize::for(Actions::COLLECT_REJECT_CARD, ['card' => Card::class]));
        Route::patch('/cancel')
            ->name(Routes::COLLECT_CANCEL_CARD)->uses(CancelCardController::class)
            ->middleware(Authorize::for(Actions::COLLECT_CANCEL_CARD, ['card' => Card::class]));
    });
});
