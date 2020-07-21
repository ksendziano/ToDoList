<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $users;
    public function __construct()
    {
        $this->middleware('auth');
        $users = User::all();
    }
    public function index(Request $request)
    {
        $this ->authorize('action',$request->user());
        $users = User::all();
        return view('users.moderator', [
            'users'=> $users,
        ]);
    }
}
