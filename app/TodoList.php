<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    //
    protected $fillable = ['title','user_id','status'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
