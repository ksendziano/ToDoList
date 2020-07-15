<?php

namespace App\Http\Controllers;

use App\Repositories\BoardRepository;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    protected $boards;
    protected $tasks;
    public function __construct(BoardRepository $boards)
    {
        $this->middleware('auth');
        $this->boards=$boards;
    }
    public function index(Request $request)
    {

        return view('boards.index', [
            'boards' => $this->boards->forUser($request->user()),
            'tasks'  => $request->user()->tasks(),
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $request->user()->boards()->create([
            'name' => $request->name,
            'color'=> $request->color,
        ]);

        return redirect('/boards');
    }
<<<<<<< Updated upstream
=======
    public function edit($id)
    {
        //
    }
    public function destroy(Request $request, Board $board)
    {
        $this ->authorize('destroy',$board);
        $board->delete();
        return redirect('/boards');
    }
>>>>>>> Stashed changes
}
