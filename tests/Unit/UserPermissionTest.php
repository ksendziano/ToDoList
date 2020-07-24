<?php
namespace Tests\Unit;

use App\Board;
use App\User;
use App\Task;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;
class UserPermissionTest extends TestCase
{

    /** @test */
    public function guestCantCreateBoards()
    {

        $response = $this->get('boards/create');
        $response->assertStatus(302);
    }
    /** @test */
    public function userCantSeeOtherUserBoard()
    {
        Task::truncate();
        Board::truncate();
        User::truncate();
        $user1 = User::create([
            'name' => 'user1',
            'password' => 'Pass1234',
            'email' => 'user1t@mail.ru'
        ]);
        $user2 = User::create([
            'name' => 'user2',
            'password' => 'Pass1234',
            'email' => 'user2t@mail.ru'
        ]);
        $board1 = Board::create([
            'user_id' => $user1->id,
            'color'=>'#FF0000',
            'name' => 'board1'
        ]);

        $board2 = Board::create([
            'user_id' => $user2->id,
            'color'=>'#FF0000',
            'name' => 'board2'
        ]);
        $response = $this->actingAs($user1)->get(route('boards.show', [$board2->id]));
        $user1->delete();
        $user2->delete();
        $board1->delete();
        $board2->delete();
        $response->assertStatus(403);
    }
    /** @test */
    public function userCantEditOtherUserBoard()
    {
        Task::truncate();
        Board::truncate();
        User::truncate();
        $user1 = User::create([
            'name' => 'user1',
            'password' => 'Pass1234',
            'email' => 'user1@mail.ru'
        ]);
        $user2 = User::create([
            'name' => 'user2',
            'password' => 'Pass1234',
            'email' => 'user2@mail.ru'
        ]);
        $board1 = Board::create([
            'user_id' => $user1->id,
            'color'=>'#FF0000',
            'name' => 'board1'
        ]);

        $board2 = Board::create([
            'user_id' => $user2->id,
            'color'=>'#FF0000',
            'name' => 'board2'
        ]);
        $response = $this->actingAs($user1)->get(route('boards.edit', [$board2->id]));
        $user1->delete();
        $user2->delete();
        $board1->delete();
        $board2->delete();
        $response->assertStatus(403);
    }
    /** @test */
    public function userCantDeleteOtherUserBoard()
    {
        Task::truncate();
        Board::truncate();
        User::truncate();
        $user1 = User::create([
            'name' => 'user1',
            'password' => 'Pass1234',
            'email' => 'user1@mail.ru'
        ]);
        $user2 = User::create([
            'name' => 'user2',
            'password' => 'Pass1234',
            'email' => 'user2@mail.ru'
        ]);
        $board1 = Board::create([
            'user_id' => $user1->id,
            'color'=>'#FF0000',
            'name' => 'board1'
        ]);

        $board2 = Board::create([
            'user_id' => $user2->id,
            'color'=>'#FF0000',
            'name' => 'board2'
        ]);
        $response = $this->actingAs($user1)->delete(route('boards.destroy', [$board2]));
        $user1->delete();
        $user2->delete();
        $board1->delete();
        $board2->delete();
        $response->assertStatus(403);
    }
    /** @test */
    public function userCantOpenEditOtherUserTask()
    {
        Task::truncate();
        Board::truncate();
        User::truncate();
        $user1 = User::create([
            'name' => 'user1',
            'password' => 'Pass1234',
            'email' => 'user1@mail.ru'
        ]);
        $user2 = User::create([
            'name' => 'user2',
            'password' => 'Pass1234',
            'email' => 'user2@mail.ru'
        ]);
        $board1 = Board::create([
            'user_id' => $user1->id,
            'color'=>'#FF0000',
            'name' => 'board1'
        ]);

        $board2 = Board::create([
            'user_id' => $user2->id,
            'color'=>'#FF0000',
            'name' => 'board2'
        ]);
        $task2 = Task::create([
            'name' => 'task2',
            'description' => '11edg',
            'board_id' => $board2->id,
            'user_id'  => $user2->id,
            'status' => 'a',
            'scheduled_date' => '2020-07-25',
            'real_date' => '2020-07-25'
        ]);
        $response = $this->actingAs($user1)->get(route('boards.tasks.edit', [$board2->id,$task2]));

        $user1->delete();
        $user2->delete();
        $board1->delete();
        $board2->delete();
        $task2->delete();
        $response->assertStatus(403);
    }

    /** @test */
    public function userCantMoveOtherUserTask()
    {
        Task::truncate();
        Board::truncate();
        User::truncate();
        $user1 = User::create([
            'name' => 'user1',
            'password' => 'Pass1234',
            'email' => 'user1@mail.ru'
        ]);
        $user2 = User::create([
            'name' => 'user2',
            'password' => 'Pass1234',
            'email' => 'user2@mail.ru'
        ]);
        $board1 = Board::create([
            'user_id' => $user1->id,
            'color' => '#FF0000',
            'name' => 'board1'
        ]);

        $board2 = Board::create([
            'user_id' => $user2->id,
            'color' => '#FF0000',
            'name' => 'board2'
        ]);
        $task2 = Task::create([
            'name' => 'task2',
            'description' => '11edg',
            'board_id' => $board2->id,
            'user_id' => $user2->id,
            'status' => 'a',
            'scheduled_date' => '2020-07-25',
            'real_date' => '2020-07-25'
        ]);
        $response = $this->actingAs($user1)->post(route('boards.tasks.move', [$board2->id, $task2]));

        $user1->delete();
        $user2->delete();
        $board1->delete();
        $board2->delete();
        $task2->delete();
        $response->assertStatus(403);
    }
    /** @test */
    public function userCantCopyOtherUserTask()
    {
        Task::truncate();
        Board::truncate();
        User::truncate();
        $user1 = User::create([
            'name' => 'user1',
            'password' => 'Pass1234',
            'email' => 'user1@mail.ru'
        ]);
        $user2 = User::create([
            'name' => 'user2',
            'password' => 'Pass1234',
            'email' => 'user2@mail.ru'
        ]);
        $board1 = Board::create([
            'user_id' => $user1->id,
            'color' => '#FF0000',
            'name' => 'board1'
        ]);

        $board2 = Board::create([
            'user_id' => $user2->id,
            'color' => '#FF0000',
            'name' => 'board2'
        ]);
        $task2 = Task::create([
            'name' => 'task2',
            'description' => '11edg',
            'board_id' => $board2->id,
            'user_id' => $user2->id,
            'status' => 'a',
            'scheduled_date' => '2020-07-25',
            'real_date' => '2020-07-25'
        ]);
        $response = $this->actingAs($user1)->post(route('boards.tasks.copy', [$board2->id, $task2]));

        $user1->delete();
        $user2->delete();
        $board1->delete();
        $board2->delete();
        $task2->delete();
        $response->assertStatus(403);
    }
    /** @test */
    public function userCantDestroyOtherUserTask()
    {
        Task::truncate();
        Board::truncate();
        User::truncate();
        $user1 = User::create([
            'name' => 'user1',
            'password' => 'Pass1234',
            'email' => 'user1@mail.ru'
        ]);
        $user2 = User::create([
            'name' => 'user2',
            'password' => 'Pass1234',
            'email' => 'user2@mail.ru'
        ]);
        $board1 = Board::create([
            'user_id' => $user1->id,
            'color' => '#FF0000',
            'name' => 'board1'
        ]);

        $board2 = Board::create([
            'user_id' => $user2->id,
            'color' => '#FF0000',
            'name' => 'board2'
        ]);
        $task2 = Task::create([
            'name' => 'task2',
            'description' => '11edg',
            'board_id' => $board2->id,
            'user_id' => $user2->id,
            'status' => 'a',
            'scheduled_date' => '2020-07-25',
            'real_date' => '2020-07-25'
        ]);
        $response = $this->actingAs($user1)->delete(route('boards.tasks.destroy', [$board2->id, $task2]));
        $user1->delete();
        $user2->delete();
        $board1->delete();
        $board2->delete();
        $task2->delete();
        $response->assertStatus(403);
    }
}
