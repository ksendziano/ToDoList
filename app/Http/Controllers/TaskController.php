<?php

namespace App\Http\Controllers;

use App\Board;
use App\Http\Requests;
use App\Repositories\TaskRepository;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    protected $tasks;
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;
    }

    public function store(Request $request,$board_id)
    {
        //$this ->authorize('store',$user_id);
        $board = Board::find($board_id);
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $request->user()->tasks()->create([
            'name' => $request->name,
            'board_id'=>$board_id,
            'description'=>$request->description,
            'scheduled_date'=>$request->scheduled_date,
            'real_date'=>$request->scheduled_date,
            'status'=>$request->status,
        ]);
        return redirect()->route('boards.show',['board_id'=>$board_id]);
    }
    public function copy(Request $request,$board_id,Task $task)
    {
        $this ->authorize('action',$task);
        $request->user()->tasks()->create([
            'name' => $task->name,
            'board_id' => $request->board_id,
            'description' => $task->description,
            'scheduled_date' => $task->scheduled_date,
            'real_date' => $task->scheduled_date,
            'status' => $task->status,
        ]);
        return redirect()->route('boards.show',['board_id'=>$board_id]);
    }
    public function move(Request $request,$board_id,Task $task)
    {
        $this ->authorize('action',$task);
        $task->board_id = $request->board_id;
        $task->save();
        return redirect()->route('boards.show',['board_id'=>$board_id]);
    }
    public function edit(Request $request,$board_id, Task $task)
    {
        $this ->authorize('action',$task);
        return view('tasks.edit', [
            'task' => $task,
            'board_id'=>$board_id,
        ]);
    }
    public function update(Request $request,$board_id,$task_id)
    {
        $task=Task::find($task_id);
        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'scheduled_date' => $request->scheduled_date,
            'real_date' => $request->real_date,
            'status' => $request->status,
        ]);
        return redirect()->route('boards.show',['board_id'=>$board_id]);
    }
    public function destroy(Request $request,$board_id, Task $task)
    {
        $this ->authorize('action',$task);
        $task->delete();
        return redirect()->route('boards.show',['board_id'=>$board_id]);
    }
}
