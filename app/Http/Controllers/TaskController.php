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
        ]);


        return redirect('/boards');
    }
    public function destroy(Request $request, Task $task)
    {
        $this ->authorize('destroy',$task);
        $task->delete();
        return redirect('/tasks');
    }
}
