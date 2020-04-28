<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['theme_id', 'title', 'excerpt', 'file_path', 'user_id'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function path()
    {
        return route('documents.show', $this);
    }
}
