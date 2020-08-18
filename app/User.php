<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'masp', 'admin'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getUserByMasp($masp)
    {
        return User::where('masp', $masp)->first();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
