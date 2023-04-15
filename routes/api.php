<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::post('/logout', [RegisteredUserController::class, 'logout']);
    Route::get('/users', [RegisteredUserController::class, 'getUsers']);
    Route::resource("project", ProjectController::class)->except('create', 'edit');
    Route::resource("collaborator", CollaboratorController::class)->except('create', 'edit');
    Route::resource("task", TaskController::class)->except('create', 'edit');
    Route::delete('/tasks/{id}', [TaskController::class,'removeTask']);
    Route::get('taskprojects/{id}', [TaskController::class, 'task']);
    Route::get('collaborate/{id}', [CollaboratorController::class, 'collaborate']);
    Route::put('taskprojects/update/{id}', [TaskController::class, 'updateTask']);
});


Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [RegisteredUserController::class, 'login']);

