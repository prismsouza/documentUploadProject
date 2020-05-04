<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function path()
    {
        return route('tags.index', $this);
    }
}
