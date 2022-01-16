<?php

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use App\Models\Collect\Program;
use App\Models\Collect\Task;
use App\Models\Company;
use CardzApp\Api\Collect\Controllers\Achievement\AddAchievementController;
use CardzApp\Api\Collect\Controllers\Achievement\GetAchievementsController;
use CardzApp\Api\Collect\Controllers\Achievement\RemoveAchievementController;
use CardzApp\Api\Collect\Controllers\Card\CancelCardController;
use CardzApp\Api\Collect\Controllers\Card\GetCardsController;
use CardzApp\Api\Collect\Controllers\Card\IssueCardController;
use CardzApp\Api\Collect\Controllers\Card\RejectCardController;
use CardzApp\Api\Collect\Controllers\Card\RewardCardController;
use CardzApp\Api\Collect\Controllers\Card\UpdateCardController;
use CardzApp\Api\Collect\Controllers\Program\AddProgramController;
use CardzApp\Api\Collect\Controllers\Program\GetProgramController;
use CardzApp\Api\Collect\Controllers\Program\GetProgramsController;
use CardzApp\Api\Collect\Controllers\Program\UpdateProgramActiveController;
use CardzApp\Api\Collect\Controllers\Program\UpdateProgramController;
use CardzApp\Api\Collect\Controllers\Task\AddTaskController;
use CardzApp\Api\Collect\Controllers\Task\GetTaskController;
use CardzApp\Api\Collect\Controllers\Task\GetTasksController;
use CardzApp\Api\Collect\Controllers\Task\UpdateTaskActiveController;
use CardzApp\Api\Collect\Controllers\Task\UpdateTaskController;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
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
        Route::get('/')
            ->name(Routes::COLLECT_GET_CARDS)->uses(GetCardsController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_CARDS, ['program' => Program::class]));
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
        Route::patch('/reward')
            ->name(Routes::COLLECT_REWARD_CARD)->uses(RewardCardController::class)
            ->middleware(Authorize::for(Actions::COLLECT_REWARD_CARD, ['card' => Card::class]));
    });

    Route::prefix('/card/id/{card}/achievements')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Routes::COLLECT_ADD_ACHIEVEMENT)->uses(AddAchievementController::class)
            ->middleware(Authorize::for(Actions::COLLECT_ADD_ACHIEVEMENT, ['card' => Card::class]));
        Route::get('/')
            ->name(Routes::COLLECT_GET_ACHIEVEMENTS)->uses(GetAchievementsController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_ACHIEVEMENTS, ['card' => Card::class]));
    });

    Route::prefix('/achievement/id/{achievement}')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::delete('/')
            ->name(Routes::COLLECT_REMOVE_ACHIEVEMENT)->uses(RemoveAchievementController::class)
            ->middleware(Authorize::for(Actions::COLLECT_REMOVE_ACHIEVEMENT, ['achievement' => Achievement::class]));
    });
});
