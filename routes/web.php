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
    Route::get('my-tasks', [App\Http\Controllers\TaskController::class, 'myTasksIndex'])->name('mytasks.index');
    Route::resource('defects', App\Http\Controllers\DefectController::class);
    Route::get('getDefects', [App\Http\Controllers\DefectController::class, 'getDefects']);
    Route::resource('meetings', App\Http\Controllers\MeetingController::class);
    Route::put('meeting/{meeting}/status', [App\Http\Controllers\MeetingController::class, 'changeMeetingStatus'])->name('meetings.status.update');
    Route::resource('appointments', App\Http\Controllers\AppointmentController::class);
    Route::resource('teams', App\Http\Controllers\TeamController::class);
    Route::get('team/{team}/members', [App\Http\Controllers\TeamController::class, 'getTeamMembers']);
    Route::resource('todos', App\Http\Controllers\TodoController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('getUsers', [App\Http\Controllers\UserController::class, 'getUsers']);
    Route::get('user/role-permissions/{user}/edit', [App\Http\Controllers\UserController::class, 'editUserRolePermissions'])->name('users.roles-permissions.edit');
    Route::put('user/role-permissions/{user}', [App\Http\Controllers\UserController::class, 'updateUserRolePermissions'])->name('users.roles-permissions.update');
});














