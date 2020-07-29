<?php
namespace Tests\Unit;

use App\Board;
use App\User;
use App\Task;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class UserPermissionTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function guestCantCreateBoards()
    {

        $response = $this->get('api/boards/create');
        $response->assertStatus(302);
    }
    /** @test */
    public function userCantSeeOtherUserBoard()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $response = $this->actingAs($user1)->get(route('boards.tasks.index', [$board2->id]));

        $response->assertStatus(403);
    }
    /** @test */
    public function userCantOpenEditOtherUserBoard()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $response = $this->actingAs($user1)->get(route('boards.edit', [$board2->id]));

        $response->assertStatus(403);
    }
    /** @test */
    public function userCantEditOtherUserBoard()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $response = $this->actingAs($user1)->post(route('boards.update', [$board2->id]));
        $response->assertStatus(403);
    }
    /** @test */
    public function userCantDeleteOtherUserBoard()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $response = $this->actingAs($user1)->delete(route('boards.destroy', [$board2]));

        $response->assertStatus(403);
    }

    /** @test */
    public function userCantCreateTaskOtherUserBoard()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->post(route('boards.tasks.store', [$board2->id,$task2->id]));
        $response->assertStatus(403);
    }

    /** @test */
    public function userCantOpenEditOtherUserTask()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->get(route('boards.tasks.edit', [$board2->id,$task2->id]));
        $response->assertStatus(403);
    }
    /** @test */
    public function userCantEditOtherUserTask()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->post(route('boards.tasks.update', [$board2->id,$task2->id]));
        $response->assertStatus(403);
    }

    /** @test */
    public function userCantMoveOtherUserTask()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->post(route('boards.tasks.move', [$board2->id, $task2->id]));
        $response->assertStatus(403);
    }

    /** @test */
    public function userCantCopyOtherUserTask()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->post(route('boards.tasks.copy', [$board2->id, $task2]));
        $response->assertStatus(403);
    }

    /** @test */
    public function userCantDestroyOtherUserTask()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->delete(route('boards.tasks.destroy', [$board2->id, $task2]));
        $response->assertStatus(403);
    }

    /** @test */
    public function moderCanSeeOtherUserBoard()
    {
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $response = $this->actingAs($user1)->get(route('boards.tasks.index', [$board2->id]));

        $response->assertOk();
    }
    /** @test */
    public function moderCanEditOtherUserBoard()
    {
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $response = $this->actingAs($user1)->post(route('boards.update', [$board2->id]));
        $response->assertOk();
    }
    /** @test */
    public function moderCanDeleteOtherUserBoard()
    {
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $response = $this->actingAs($user1)->delete(route('boards.destroy', [$board2]));

        $response->assertStatus(204);
    }


    /** @test */
    public function moderCanMoveOtherUserTask()
    {
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->post(route('boards.tasks.move', ['board_id'=>$board2->id, 'task_id'=>$task2->id, 'to_board_id' => $board1->id]));
        $response->assertOk();
    }

    /** @test */
    public function moderCanCopyOtherUserTask()
    {
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->post(route('boards.tasks.copy', ['board_id'=>$board2->id, 'task_id'=>$task2->id, 'to_board_id' => $board1->id]));
        $response->assertOk();
    }

    /** @test */
    public function moderCanDestroyOtherUserTask()
    {
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->delete(route('boards.tasks.destroy', [$board2->id, $task2]));
        $response->assertStatus(204);
    }
    private function createUser()
    {
        $user = factory('App\User')->create();
        $user->moderator = 0;
        return $user;
    }

    private function createModerator()
    {

        $moderator = factory(User::class)->create();
        $moderator->moderator = 1;
        return $moderator;
    }

    private function createBoard(int $user_id)
    {
        /*$board = factory(Board::class)->make([
            'user_id' => $user_id,
        ])->save();*/
        $board = factory(Board::class)->create();
        $board->user_id = $user_id;
        $board->save();
        return $board;
    }

    private function createTask($user_id,$board_id)
    {
        $task = factory(Task::class)->create();
        $task->board_id = $board_id;
        $task->user_id = $user_id;
        $task->save();
        return $task;
    }

}
