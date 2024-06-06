<?php

use App\Actions\CreateNewProject;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects/{project}', [ProjectsController::class, 'index']);

Route::get('/upload', [UploadController::class, 'index']);

Route::post('/upload', [UploadController::class, 'create'])->name('upload');

Route::get('/api/projects/{project}', [ProjectsController::class, 'fetchTasks']);

Route::post('/api/projects/{project}/tasks', [ProjectsController::class, 'create']);

Route::delete('/api/projects/tasks/{id}', [ProjectsController::class, 'delete']);

Route::post('/projects/create', CreateNewProject::class)->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
