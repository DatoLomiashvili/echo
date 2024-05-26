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
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProjectsController extends Controller
{

    /**
     * @param Project $project
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(Project $project): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $project->load('tasks');

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
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(Project $project): JsonResponse
    {
        $task = $project->tasks()->create(['body' => request()->get('body')]);
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
        TaskDeleted::dispatch($task);
        $task->delete();

        return response()->json(['success' => true]);
    }
}
