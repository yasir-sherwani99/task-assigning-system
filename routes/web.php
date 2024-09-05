<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| System
|--------------------------------------------------------------------------
|
| The system routes
|
*/
Auth::routes();
Route::middleware('auth')->group(function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('clients', App\Http\Controllers\ClientController::class);
    Route::get('clients-datatable', [App\Http\Controllers\ClientController::class, 'getClients']);
    Route::get('client/{client}/status', [App\Http\Controllers\ClientController::class, 'changeStatus']);
    Route::resource('projects', App\Http\Controllers\ProjectController::class);
    Route::get('projects-datatable', [App\Http\Controllers\ProjectController::class, 'getProjects']);
    Route::delete('projects2/{project}', [App\Http\Controllers\ProjectController::class, 'destroy2']);
    Route::put('project/{project}/status', [App\Http\Controllers\ProjectController::class, 'changeProjectStatus'])->name('projects.status.update');
    Route::get('project/{project}/team-members', [App\Http\Controllers\ProjectController::class, 'getProjectTeamMembers']);
    Route::put('project/{project}/progress', [App\Http\Controllers\ProjectController::class, 'updateProjectProgress'])->name('projects.progress.update');
    Route::resource('tasks', App\Http\Controllers\TaskController::class);
    Route::get('tasks-datatable', [App\Http\Controllers\TaskController::class, 'getTasks']);
    Route::delete('tasks2/{task}', [App\Http\Controllers\TaskController::class, 'destroy2']);
    Route::put('task/{task}/status', [App\Http\Controllers\TaskController::class, 'updateTaskStatus'])->name('tasks.status.update');
    Route::get('my-tasks', [App\Http\Controllers\TaskController::class, 'myTasksIndex'])->name('mytasks.index');
    Route::get('mytasks-datatable', [App\Http\Controllers\TaskController::class, 'getMyTasks']);
    Route::put('task/{task}/progress', [App\Http\Controllers\TaskController::class, 'updateTaskProgress'])->name('tasks.progress.update');
    Route::resource('defects', App\Http\Controllers\DefectController::class);
    Route::get('defects-datatable', [App\Http\Controllers\DefectController::class, 'getDefects']);
    Route::put('defect/{defect}/status', [App\Http\Controllers\DefectController::class, 'updateDefectStatus'])->name('defects.status.update');
    Route::resource('meetings', App\Http\Controllers\MeetingController::class);
    Route::get('meetings-datatable', [App\Http\Controllers\MeetingController::class, 'getMeetings']);
    Route::put('meeting/{meeting}/status', [App\Http\Controllers\MeetingController::class, 'changeMeetingStatus'])->name('meetings.status.update');
    Route::resource('appointments', App\Http\Controllers\AppointmentController::class);
    Route::get('appointments-datatable', [App\Http\Controllers\AppointmentController::class, 'getAppointments']);
    Route::put('appointment/{appointment}/status', [App\Http\Controllers\AppointmentController::class, 'changeAppointmentStatus'])->name('appointments.status.update');
    Route::resource('teams', App\Http\Controllers\TeamController::class);
    Route::get('teams-datatable', [App\Http\Controllers\TeamController::class, 'getTeams']);
    Route::get('team/{team}/members', [App\Http\Controllers\TeamController::class, 'getTeamMembers']);
    Route::delete('teams2/{team}', [App\Http\Controllers\TeamController::class, 'destroy2']);
    Route::resource('todos', App\Http\Controllers\TodoController::class);
    Route::prefix('report')->group(function () {
        Route::get('project', [App\Http\Controllers\ReportController::class, 'projectReportIndex'])->name('report.project.index');
        Route::get('project-datatable', [App\Http\Controllers\ReportController::class, 'getProjectReport']);
        Route::get('task', [App\Http\Controllers\ReportController::class, 'taskReportIndex'])->name('report.task.index');
        Route::get('task-datatable', [App\Http\Controllers\ReportController::class, 'getTaskReport']);
        Route::get('defect', [App\Http\Controllers\ReportController::class, 'defectReportIndex'])->name('report.defect.index');
        Route::get('defect-datatable', [App\Http\Controllers\ReportController::class, 'getDefectReport']);
    });
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users-datatable', [App\Http\Controllers\UserController::class, 'getUsers']);
    Route::get('user/role-permissions/{user}/edit', [App\Http\Controllers\UserController::class, 'editUserRolePermissions'])->name('users.roles-permissions.edit');
    Route::put('user/role-permissions/{user}', [App\Http\Controllers\UserController::class, 'updateUserRolePermissions'])->name('users.roles-permissions.update');
    Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
    Route::get('notifications-datatable', [App\Http\Controllers\NotificationController::class, 'getNotifications']);
    // Mark notifications read
	Route::get('notifications-mark-read', [App\Http\Controllers\NotificationController::class, 'readAllNotifications'])->name('notifications.read');
    Route::get('password', [App\Http\Controllers\SettingController::class, 'createPassword'])->name('password.create');
    Route::post('password', [App\Http\Controllers\SettingController::class, 'changePassword'])->name('password.change');
});














