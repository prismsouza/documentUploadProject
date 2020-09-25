<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;


class Document extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'date', 'is_active', 'user_id'];
    public $perPage = 20;
    use SoftDeletes, CascadeSoftDeletes;
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['files', 'messages'];
    /**
     * @var int|mixed
     */

    public function getPerPage() {
        return $this->perPage;
    }

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

    public function setOtherCategory()
    {
        $this->category_id = 24;
        $this->save();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);//->withTimestamps();
    }

    public function hasdocument()
    {
        return $this->belongsToMany('App\Document', 'document_has_document', 'document_id', 'document_related_id');
    }

    public function hasboletim()
    {
        return $this->belongsToMany(Boletim::class, 'document_has_boletim', 'document_id', 'boletim_id');
    }

    public function hasbeenrevoked()
    {
        return $this->belongsToMany('App\Document', 'document_revoked_by','document_id', 'document_successor_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
