<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['theme_id', 'name', 'description', 'file_path', 'user_id'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function path()
    {
        return route('documents.show', $this);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);//->withTimestamps();
    }
}
