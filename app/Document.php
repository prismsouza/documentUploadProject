<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'date', 'is_active', 'file_name', 'user_id'];
    protected $searchable = [
        'columns' => [
            'documents.name' => 10,
            'documents.date' => 5,
            'documents.bio' => 3,
            'profiles.country' => 2,
            'profiles.city' => 1,
        ],
        'joins' => [
            'profiles' => ['users.id','profiles.user_id'],
        ],
    ];
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);//->withTimestamps();
    }
}
