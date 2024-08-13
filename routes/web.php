<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

/*
|--------------------------------------------------------------------------
| User/Team Member
|--------------------------------------------------------------------------
|
| The users routes
|
*/
Auth::routes();
Route::middleware('auth')->group(function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('clients', App\Http\Controllers\ClientController::class);
    Route::get('getClients', [App\Http\Controllers\ClientController::class, 'getClients']);
    Route::resource('projects', App\Http\Controllers\ProjectController::class);
    Route::put('project/{project}/status', [App\Http\Controllers\ProjectController::class, 'changeProjectStatus'])->name('projects.status.update');
    Route::get('project/{project}/team-members', [App\Http\Controllers\ProjectController::class, 'getProjectTeamMembers']);
    Route::resource('tasks', App\Http\Controllers\TaskController::class);
    Route::put('task/{task}/status', [App\Http\Controllers\TaskController::class, 'changeTaskStatus'])->name('tasks.status.update');
    Route::resource('defects', App\Http\Controllers\DefectController::class);
    Route::get('getDefects', [App\Http\Controllers\DefectController::class, 'getDefects']);
    Route::resource('teams', App\Http\Controllers\TeamController::class);
    Route::get('team/{team}/members', [App\Http\Controllers\TeamController::class, 'getTeamMembers']);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('getUsers', [App\Http\Controllers\UserController::class, 'getUsers']);
});
