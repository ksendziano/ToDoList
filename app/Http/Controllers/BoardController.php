<?php

namespace App\Http\Controllers;

use App\Board;
use App\User; # не используется
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
    public function index(Request $request) # можно сделать тернарный оператор и сократить количество строк кода
    {
        if($request->user()->isModerator()){
            $boards = Board::all();# надо переименовать, у тебя у класса есть protected $boards; 
            #так делать как минимум нехорошо https://wiki.sei.cmu.edu/confluence/display/c/DCL01-C.+Do+not+reuse+variable+names+in+subscopes
            # https://wiki.sei.cmu.edu/confluence/display/java/DCL51-J.+Do+not+shadow+or+obscure+identifiers+in+subscopes
        }
        else{
            $boards=$request->user()->boards; # -||-
        }
        return response()->json($boards,200);

    }
    public function create(Request $request)
    {
        return view('boards.create');
    }
    public function store(Request $request) # не понял, что тут происходит и как, очень странные дела тут происходят, оставь комментарии по поводу работы метода
    {
        $this->validate($request, [ # повторяющиеся штуки можно вынести в отдельный метод...
            'name' => 'required|max:255',
        ]);
        $request->user()->boards()->create([
            'user_id'=> $request->user()->id,# здесь
            'name' => $request->name,
            'color'=> $request->color,
        ]);
        $board =Board::where('user_id',$request->user()->id);# думаю, мы тут не одну доску получаем, логичный нейминг userBoards or user_boards, конечно, если я не ошибаюсь

        return response()->json($board,200);
    }

    public function edit(Request $request,$board_id) # $request никак не используется, неужели в request нельзя добавить board_id? Зачем лишний параметр пихать?
    {
        $board = Board::find($board_id);
        $this ->authorize('action',$board);
        return view('boards.edit', [
            'board'=>$board,
        ]);
    }
    public function update(Request $request,$board_id)# то же самое, что и по поводу предыдущего метода, если есть сакральный смысл, прошу пояснить.
    {
        $board = Board::find($board_id);
        $this ->authorize('action',$board);
        $board = $board->update($request->all());
        $response_data['boards']=$board; # boards = board???
        return response()->json($response_data, 200);
    }
    public function destroy(Board $board)
    {
        $this ->authorize('action',$board);
        $board->tasks()->delete();# может как-то можно сделать, чтобы при удалении доски каскадно удалялись и связанные таски? без явного удаление ручками
        $board->delete();
        return response(null, 204);
    }
    public function download(Request $request)
    {
        if ($request->user()->isModerator()) {
            $boards = Board::all(); # см. первые комментарии
        } else {
           $boards = $request->user()->boards;
        }
        if (count($boards) == 0) #if not $boards
            return redirect()->route('boards.index');
        $zip_archive = new \ZipArchive();
        $zip_file_name = 'board.zip';
        $zip_archive->open($zip_file_name, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        foreach($boards as $board) {
            $board_serialized['name'] = $board->name;#
            $board_serialized['user'] = $board->user->name;# чтобы нейминг доски и юера не совпадал, можно было использовать title для board
            $board_serialized['tasks'] = $board->tasks;
            Storage::disk('local')->put('board'.$board->id.'.json', json_encode($board_serialized));#'.json' вынеси в константы если используешь больше одного раза
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
