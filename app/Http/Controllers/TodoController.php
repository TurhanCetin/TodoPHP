<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Models\User;

class TodoController extends Controller
{
/*
todo:
    - mail gönderme
*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \Auth::user()->todos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $todo = $user->todos()->create(
            $request->only('title','done') + [
                'sender_id' => $request->user()->id
            ]
        );

        return response()->json([
            'text' => 'Task Oluşturuldu.',
            'task' => $todo
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        abort_unless($todo->user_id === $request->user()->id, 403);
        $todo->load('user','sender');
        return $todo;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        abort_unless($todo->user_id === $request->user()->id, 403);
        return response()->json([
            'text' => 'Task Güncellendi.',
            'task' => $todo->update($request->only('title','done'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo, Request $request)
    {
        $id = $todo->id;
        abort_unless($id === $request->user()->id, 403);
        $todo->delete();
        return response()->json([
            'text' => 'Task Silindi',
            'task_id' => $id
        ]);
    }
}