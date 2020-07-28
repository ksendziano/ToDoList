<?php

namespace App\Http\Controllers;

use App\Board;
use App\Http\Requests;
use App\Repositories\TaskRepository;
use App\Task;
use App\User;
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
    public function index(Request $request,$board_id)
    {
        $board = Board::find($board_id);
        $tasks = $board->tasks;
        if (!policy(Task::class)->index($request->user(), $board)) {
            abort(403);
        }
        return response()->json($tasks,200);
    }
    public function create(Request $request,$board_id)
    {
        $board = Board::find($board_id);
        if (!policy(Task::class)->create($request->user(), $board)) {
            abort(403);
        }
        return view('tasks.create',['board_id'=>$board_id]);
    }
    public function store(Request $request,$board_id)
    {
        $board = Board::find($board_id);
        if (!policy(Task::class)->create($request->user(), $board)) {
            abort(403);
        }
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required | max:255',
            'scheduled_date' => 'required'
        ]);
        $board->user->tasks()->create([
            'name' => $request->name,
            'board_id'=>$board_id,
            'description'=>$request->description,
            'scheduled_date'=>$request->scheduled_date,
            'real_date'=>$request->scheduled_date,
            'status'=>$request->status,
        ]);
        $task=Task::where('name',$request->name);
        return response()->json($task,200);
    }
    public function copy(Request $request,$board_id,$task_id)
    {
        $task=Task::find($task_id);
        $this ->authorize('action',$task);
        $request->user()->tasks()->create([
            'name' => $task->name,
            'board_id' => $request->to_board_id,
            'description' => $task->description,
            'scheduled_date' => $task->scheduled_date,
            'real_date' => $task->scheduled_date,
            'status' => $task->status,
        ]);
        return response(null, 200);
    }
    public function move(Request $request,$board_id,$task_id)
    {
        $task=Task::find($task_id);
        $this ->authorize('action',$task);
        $task->board_id = $request->to_board_id;
        $task->save();
        return response(null, 200);
    }
    public function edit(Request $request,$board_id, $task_id)
    {
        $task=Task::find($task_id);
        $this ->authorize('action',$task);
        return view('tasks.edit', [
            'task' => $task,
            'board_id'=>$board_id,
        ]);
    }
    public function update(Request $request,$board_id,$task_id)
    {
        $task = Task::find($task_id);
        $this ->authorize('action',$task);
        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'scheduled_date' => $request->scheduled_date,
            'real_date' => $request->real_date,
            'status' => $request->status,
        ]);
        return response()->json($task, 200);
    }
    public function destroy(Request $request,$board_id, $task_id)
    {
        $task=Task::find($task_id);
        $this ->authorize('action',$task);
        $task->delete();
        return response(null, 204);
    }
}
