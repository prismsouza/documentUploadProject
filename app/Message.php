<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    protected $fillable = ['message'];
    public $perPage = 10;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function path()
    {
        return route('messages.index');
    }

}
