<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['title', 'excerpt', 'file_path', 'author_cod'];

    public function path()
    {
        return route('documents.show', $this);
    }
}
