<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    protected $fillable = ['id', 'name'];
    use SoftDeletes;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
