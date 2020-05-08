<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'date', 'is_active', 'file_name', 'user_id'];

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

    public function relateddocuments()
    {
        return $this->belongsToMany('App\Document', 'document_has_document', 'document_id', 'document_related_id');
    }

    public function hasdocument()
    {
        return $this->belongsToMany('App\Document', 'document_has_document', 'document_id', 'document_related_id');
    }
}
