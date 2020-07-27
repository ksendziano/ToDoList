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
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $response = $this->actingAs($user1)->get(route('boards.tasks.index', [$board2->id]));

        $response->assertOk();
    }
    /** @test */
    public function moderCanOpenEditOtherUserBoard()
    {
        $this->clearDatabase();
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $response = $this->actingAs($user1)->get(route('boards.edit', [$board2->id]));
        $response->assertOk();
    }
    /** @test */
    public function moderCanEditOtherUserBoard()
    {
        $this->clearDatabase();
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
        $this->clearDatabase();
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
        $this->clearDatabase();
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->post(route('boards.tasks.move', [$board2->id, $task2]));
        $response->assertOk();
    }

    /** @test */
    public function moderCanCopyOtherUserTask()
    {
        $this->clearDatabase();
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->post(route('boards.tasks.copy', [$board2->id, $task2]));
        $response->assertOk();
    }

    /** @test */
    public function moderCanDestroyOtherUserTask()
    {
        $this->clearDatabase();
        $user1 = $this->createModerator();
        $user2 = $this->createUser();
        $board1 = $this->createBoard($user1->id);
        $board2 = $this->createBoard($user2->id);
        $task2 = $this->createTask($user2->id,$board2->id);
        $response = $this->actingAs($user1)->delete(route('boards.tasks.destroy', [$board2->id, $task2]));
        $response->assertStatus(204);
    }
    private function clearDatabase()
    {
        Task::truncate();
        Board::truncate();
        User::truncate();
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
