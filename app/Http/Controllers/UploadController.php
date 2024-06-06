<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('upload');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,gif',
        ]);

        DB::transaction(function () use ($request){
            $project = Project::create([
                'title' => 'newProject',
            ])->addMediaFromRequest('image')
                ->toMediaCollection();
        });

    }
}

