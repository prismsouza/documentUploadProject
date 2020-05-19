<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function path()
    {
        return route('messages.index');
    }

}
