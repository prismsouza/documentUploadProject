<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['theme_id', 'name', 'description', 'date', 'is_active', 'file_name', 'user_id'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function path()
    {
        return route('documents.show', $this);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
