<?php

namespace App\Http\Controllers;

use App\Board;
use App\User;
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
    public function showBoards(Request $request,$user_id)
    {
        //$this ->authorize('action',$board);
        $user=User::find($user_id);
        return view('boards.index', [
            'boards' => $this->boards->forUser($user),
            'user_id' => $user_id,
        ]);
    }
    public function index(Request $request,$user_id,$board_id)
    {
        $board = Board::find($board_id);
        $this ->authorize('action',$board);
        $user = User::find($board->user_id);

        return view('boards.boards', [
            'boards' => $this->boards->forUser($user),
            'board' => $board,
            'tasks'  => $user->tasks(),
            'user_id' => $board->user_id,
        ]);
    }
   //
    public function store(Request $request,$user_id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $request->user()->boards()->create([
            'name' => $request->name,
            'color'=> $request->color,
        ]);

        return redirect('/user'.$user_id.'/boards');
    }

    public function edit($id)
    {

        //
    }
    public function destroy(Request $request,$user_id, Board $board)
    {
        $this ->authorize('action',$board);
        $board->tasks()->delete();
        $board->delete();
        return redirect('/user'.$user_id.'/boards');
    }

}
