<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInvitationController;
use App\Http\Controllers\ProjectTaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{project}/tasks', [ProjectTaskController::class, 'store']);
    Route::patch('/projects/{project}/tasks/{task}', [ProjectTaskController::class, 'update']);
    Route::post('/projects/{project}/invitations', [ProjectInvitationController::class, 'store']);
    Route::get('/home', [ProjectController::class, 'index'])->name('home');
});

Auth::routes();
