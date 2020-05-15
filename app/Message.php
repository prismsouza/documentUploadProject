<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message'];
    public $timestamps = false;

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
