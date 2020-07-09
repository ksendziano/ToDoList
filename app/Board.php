<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public function tasks()
    {
        return $this->hasMany(task::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
