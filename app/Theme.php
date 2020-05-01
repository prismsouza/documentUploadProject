<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = ['title', 'description'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function path()
    {
        return route('documents_theme.index', $this);
    }

    public function pathTheme()
    {
        return route('documents.index', $this);
    }
}
