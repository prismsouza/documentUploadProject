<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Boletim extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'date', 'user_id'];
    protected $table = "boletins";
    public $perPage = 20;
    use SoftDeletes, CascadeSoftDeletes;
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['files', 'messages'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function path()
    {
        return route('boletins.show', $this);
    }
    public function path_admin()
    {
        return route('boletins_admin.show', $this);
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

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
