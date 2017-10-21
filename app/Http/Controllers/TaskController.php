<?php

namespace App\Http\Controllers;

use App\{Task, Status};
use Illuminate\Http\Request;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function tasks()
    {
        return Task::with('status')
            ->orderBy('order', 'desc')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:128',
            'status_id' => 'required|integer|in:1,2,3',
        ], [
            'name.*' => 'Name is invalid!',
            'status_id.*' => 'Status is invalid!',
        ]);

        $task = new Task($request->all());
        $task->order = $task->max('order') + 100;

        $result = $task->save();

        $statuses = Status::all();

        return response()->json([
            'success' => (int) $result,
            'task' => view('partials.task', compact('task', 'statuses'))->render(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'name' => 'max:128',
            'status_id' => 'integer|in:1,2,3',
            'order' => 'numeric',
        ], [
            'name.*' => 'Name is invalid!',
            'status_id.*' => 'Status is invalid!',
            'order.*' => 'Status is invalid!',
        ]);

        return response()->json([
            'success' => (int) $task->update($request->all()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        return response()->json([
            'success' => (int) $task->delete(),
        ]);
    }
}
