<?php

namespace App\Http\Controllers;

use App\Board;
use App\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        //$this ->authorize('action',$board);
        $boards=Board::all();
        if($request->user()->isModerator()){
            return view('boards.index', [
                'boards' => $boards,
                'user_id' => $request->user()->id,
            ]);
        }
        else{
            return view('boards.index', [
                'boards' => $this->boards->forUser($request->user()),
                'user_id' => $request->user()->id,
            ]);
        }
    }

    public function show(Request $request,$board_id)
    {
        $board=Board::find($board_id);
        $this ->authorize('action',$board);
        $user = User::find($board->user_id);
        return view('boards.boards', [
            'boards' => $this->boards->forUser($user),
            'board' => $board,
            'tasks'  => $user->tasks(),
            'board_id'=>$board->id,
            'user_id' => $board->user_id,
        ]);
    }
   //
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $request->user()->boards()->create([
            'user_id'=>$request->user()->id,
            'name' => $request->name,
            'color'=> $request->color,
        ]);

        return redirect()->route('boards.index');
    }

    public function edit(Request $request,$board_id)
    {
        $board=Board::find($board_id);
        $this ->authorize('action',$board);
        return view('boards.edit', [
            'board'=>$board,
        ]);
    }
    public function update(Request $request,$board_id)
    {
        $board=Board::find($board_id);
        $this ->authorize('action',$board);
        $board->update([
            'name' => $request->name,
            'color'=>$request->color,
        ]);
        return redirect()->route('boards.show',['board_id'=>$board->id]);
    }
    public function destroy(Request $request,Board $board)
    {
        $this ->authorize('action',$board);
        $board->tasks()->delete();
        $board->delete();
        return redirect()->route('boards.index');
    }
    public function download()
    {
        $current_user = User::find(Auth::id());
        if ($current_user->isModerator()) {
            $boards = Board::all();
        } else {
           $boards = $current_user->boards;
        }
        $boards = $current_user->boards;
        if (count($boards) == 0)
            return redirect()->route('board.index');
        $zip_archive = new \ZipArchive();
        $zip_file_name = 'board.zip';
        $zip_archive->open($zip_file_name, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $i = 1;
        foreach($boards as $board) {
            $desk_serialized['name'] = $board->name;
            $desk_serialized['user'] = $board->user->name;
            $desk_serialized['tasks'] = $board->tasks;
            Storage::disk('local')->put('board'.$i.'.json', json_encode($desk_serialized));
            $path_to_json = Storage::disk('local')->path('board'.$i.'.json');
            $zip_archive->addFile($path_to_json);
            ++$i;
        }
        $zip_archive->close();
        $i = 1;
        foreach($boards as $board) {
            Storage::disk('local')->delete('board'.$i.'.json');
            ++$i;
        }
        return response()->download($zip_file_name);

    }

}
