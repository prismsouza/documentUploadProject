<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];
    public $timestamps = false;

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
        return route('documents_category.index', $this);
    }

    public function pathCategory()
    {
        return route('documents.index', $this);
    }
}
