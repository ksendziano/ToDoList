<?php

namespace App;
use App\User;
use App\Board;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
