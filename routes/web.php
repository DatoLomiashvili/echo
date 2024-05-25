<?php

use App\Events\TaskCreated;
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

class Order {
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('tasks', function () {
    return Task::latest()->get();
});

Route::post('tasks', function (Request $request) {
    $task = Task::forceCreate(['body' => $request->get('body')]);
    TaskCreated::dispatch($task);
    return response()->json($task, 201);
});


