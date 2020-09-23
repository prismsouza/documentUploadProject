<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    protected $fillable = ['message'];
    public $perPage = 10;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function path()
    {
        return route('contacts.index');
    }
}
