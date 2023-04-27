<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function task($id)
    {
        $project = Project::find($id);

        //$tasks = Task::all();
        $todos = Task::where(["status" => "todo", "project_id" => $project->id])->get();
        $pendings = Task::where(["status" => "pending", "project_id" => $project->id])->get();
        $finished = Task::where(["status" => "finished", "project_id" => $project->id])->get();
        return response([
            'status' => "success",
            'todo' => $todos,
            'pending' => $pendings,
            'finished' => $finished,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string',
            'status' => 'required|string|max:255',
            'project_id' => 'required',
        ]);

      $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'project_id' => $request->project_id,
            'user_id' => Auth::user()->id,

        ]);
        return response([
            'status' => "success",
            'message' => "Tache ajouté avec succès",
            'task' => $task
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $tasks = Task::where("id ", $task)->get();
        return response([
            'status' => "success",
            'task' => $tasks
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $tasks = Task::where("id", $task)->update([
            "status" => $request->status,
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Tache modifiée avec succès",
            'task' => $tasks
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($task)
    {
        $tasks = Task::find($task);
        if ($tasks) {
            $tasks->delete();
        }
        return response([
            "status" => 200,
            "message" => "Tache supprimé",
            'task' => $task
        ]);
    }
    public function updateTask(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

      $task = Task::where("id", $id)->update([
            "status" => $request->status,
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Tache modifiée avec succès",
            'task' => $task
        ]);
    }
    public function removeTask($id)
    {
        $tasks = Task::find($id);
        if ($tasks) {
            $tasks->delete();
        }
        return response([
            "status" => 200,
            "message" => "Tache supprimé",
            'task' => $tasks
        ]);
    }
}
