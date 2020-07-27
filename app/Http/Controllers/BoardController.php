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
            $boards=Board::all();
        }
        else{
            $boards=$request->user()->boards;
        }
        $response_data['boards']=$boards;
        return response()->json($response_data,200);

    }
    public function create(Request $request)
    {
        return view('boards.create');
    }
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
        $board =Board::where('user_id',$request->user()->id);

        return response()->json($board,200);
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
        $board=$board->update($request->all());
        $response_data['boards']=$board;
        return response()->json($response_data, 200);
    }
    public function destroy(Request $request,Board $board)
    {
        $this ->authorize('action',$board);
        $board->tasks()->delete();
        $board->delete();
        return response(null, 204);
    }
    public function download(Request $request)
    {
        $current_user = $request->user();
        if ($current_user->isModerator()) {
            $boards = Board::all();
        } else {
           $boards = $current_user->boards;
        }
        if (count($boards) == 0)
            return redirect()->route('boards.index');
        $zip_archive = new \ZipArchive();
        $zip_file_name = 'board.zip';
        $zip_archive->open($zip_file_name, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);


        foreach($boards as $board) {
            $board_serialized['name'] = $board->name;
            $board_serialized['user'] = $board->user->name;
            $board_serialized['tasks'] = $board->tasks;
            Storage::disk('local')->put('board'.$board->id.'.json', json_encode($board_serialized));
            $path_to_json = Storage::disk('local')->path('board'.$board->id.'.json');
            $zip_archive->addFile($path_to_json);
        }
        $zip_archive->close();

        foreach($boards as $board) {
            Storage::disk('local')->delete('board'.$board->id.'.json');

        }
        return response()->download($zip_file_name);

    }

}
