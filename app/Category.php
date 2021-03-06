<?php

namespace App;

//use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'hint'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public static function getCategoriesExceptBoletim()
    {
        return Category::orderBy('name', 'asc')->get()
            ->whereNotIn('id', [1, 2, 3]);
    }

    public static function isCategoryBoletim($category)
    {
        return ($category == 1 || $category == 2 || $category == 3);
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
        return route('categories.index', $this);
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
            foreach ($category->boletins as $boletim) $boletim->setOtherCategory();

        });
    }
}
