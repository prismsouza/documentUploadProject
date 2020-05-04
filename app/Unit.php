<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['id', 'name'];
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
