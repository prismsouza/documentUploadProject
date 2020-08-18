<?php

namespace App;

//use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $fillable = ['name', 'description'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function boletins()
    {
        return $this->hasMany(Boletim::class);
    }

    public function path()
    {
        return route('documents_category.index', $this);
    }

    public function pathCategory()
    {
        return route('documents.index', $this);
    }

    public function hassubcategory()
    {
        return $this->belongsToMany('App\Category', 'category_has_subcategory', 'category_id', 'subcategory_id');
    }

    public function hasparent()
    {
        return $this->belongsToMany('App\Category', 'category_has_subcategory', 'subcategory_id', 'category_id');
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Category $category) {

            foreach ($category->documents as $document) $document->setOtherCategory();

        });
    }
}
