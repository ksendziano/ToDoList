<?php

namespace App\Http\Controllers;

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
        $this->tasks=$tasks;
    }
    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $request->user()->tasks()->create([
            'name' => $request->name,
            'board_id'=> $request->board_id,
            'description'=>$request->description,
            'scheduled_date'=>$request->scheduled_date,
            'real_date'=>$request->scheduled_date,
            'status'=>$request->status,
        ]);


        return redirect('/boards');
    }
    public function copy(Request $request,$id)
    {
        $task=Task::find($id);
        $request->user()->tasks()->create([
            'name' => $task->name,
            'board_id'=> $request->board_id,
            'description'=>$task->description,
            'scheduled_date'=>$task->scheduled_date,
            'real_date'=>$task->scheduled_date,
            'status'=>$task->status,
        ]);
        return redirect('/boards');
    }
    public function replace(Request $request,$id)
    {
        $task = Task::find($id);
        $task->board_id = $request->board_id;
        $task->save();
        return redirect('/boards');
    }
    public function openEdit(Request $request, Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }
    public function edit(Request $request,$id)
    {
        $task=Task::find($id);
        $task->update([
            'name' => $request->name,
            'description'=>$request->description,
            'scheduled_date'=>$request->scheduled_date,
            'real_date'=>$request->real_date,
            'status'=>$request->status,
        ]);
        return redirect('/boards');
    }
    public function destroy(Request $request, Task $task)
    {
        $this ->authorize('destroy',$task);
        $task->delete();
        return redirect('/boards');
    }
}
