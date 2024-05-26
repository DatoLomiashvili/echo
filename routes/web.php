<?php

use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
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

Route::get('/projects/{project}', function (Project $project){
    $project->load('tasks');

    return view('projects.show', compact('project'));
});

Route::get('/api/projects/{project}', function (Project $project) {
    return $project->tasks;
});

Route::post('/api/projects/{project}/tasks', function (Project $project) {
    $task = $project->tasks()->create(['body' => request()->get('body')]);
    TaskCreated::dispatch($task);
    return response()->json($task, 201);
});

Route::delete('/api/projects/tasks/{id}', function ($id) {
    $task = Task::find($id);
    TaskDeleted::dispatch($task);
    $task->delete();

    return response()->json(['success' => true]);
});
