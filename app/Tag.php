<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    protected $fillable = ['name'];
    use SoftDeletes;

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function path()
    {
        return route('tags.index', $this);
    }
}
