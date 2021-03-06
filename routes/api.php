<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameUtilController;
use App\Http\Controllers\GamePlayController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/users/me', [UserController::class, 'getMyData']);

Route::get('/games/in_progress', [GameUtilController::class, 'getListInProgress']);
Route::get('/games/finished', [GameUtilController::class, 'getListFinished']);
Route::post('/games', [GameUtilController::class, 'create']);
Route::delete('/games/{id}', [GameUtilController::class, 'delete']);

Route::get('/games/{id}', [GamePlayController::class, 'getState']);
Route::get('/games/{id}/logs', [GamePlayController::class, 'getDoneLogs']);
Route::post('/games/{id}/use_building', [GamePlayController::class, 'useBuilding']);
Route::post('/games/{id}/rollback_use_building', [GamePlayController::class, 'rollbackUseBuilding']);
Route::post('/games/{id}/action', [GamePlayController::class, 'action']);
Route::post('/games/{id}/discard', [GamePlayController::class, 'discard']);
Route::post('/games/{id}/sell', [GamePlayController::class, 'sell']);

