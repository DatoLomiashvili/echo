<?php

namespace App\Http\Controllers;

use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use function DeepCopy\deep_copy;

class ProjectsController extends Controller
{

    /**
     * @param Project $project
     * @return Application|View|Factory|\Illuminate\Contracts\Foundation\Application
     * @throws Throwable
     */
    public function index(Project $project): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $project->load('tasks');
//        $batch = [
//            new RegisterUser(),
//            new ProcessPayment(),
//            new SendEmail(15),
//        ];
//
//        Bus::batch($batch)->allowFailures()->onQueue('auth')->dispatch();

        return view('projects.show', compact('project'));
    }

    /**
     * @param Project $project
     * @return mixed
     */
    public function fetchTasks(Project $project): mixed
    {
        return $project->tasks;
    }

    /**
     * @param Project $project
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Project $project, Request $request): JsonResponse
    {
        if (!auth()->user()){
            return response()->json(['msg' => 'The User Is Not Authenticated'], 403);
        } elseif (!$project->participants->contains(auth()->user())) {
            return response()->json(['msg' => 'The User Is Not Allowed'], 405);
        }

        $validatedData = $request->validate([
            'body' => 'required|string',
        ]);

        $task = $project->tasks()->create(['body' => $validatedData['body']]);
        TaskCreated::dispatch($task);
        return response()->json($task, 201);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $task = Task::find($id);
        if (!auth()->user()){
            return response()->json(['msg' => 'The User Is Not Authenticated'], 403);
        } elseif (!$task->project->participants->contains(auth()->user())) {
            return response()->json(['msg' => 'The User Is Not Allowed'], 405);
        }
        TaskDeleted::dispatch($task->project->id, $task->id);
        $task->delete();

        return response()->json(['success' => true]);
    }
}
