<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function path()
    {
        //return route('logs.index', $this);
    }
}
