<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'masp'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
