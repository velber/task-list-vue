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
        return Task::orderBy('order', 'desc')
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
        $task = new Task();
        $task->order = $task->min('order') / 2;

        $result = $task->save();

        if (! $result) {
            return response('', 500);
        }

        return response()->json(['task' => $task]);
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
            'status' => 'boolean',
            'order' => 'numeric',
        ], [
            'name.*' => 'Name is invalid!',
            'status.*' => 'Status is invalid!',
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
