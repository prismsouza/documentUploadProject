<?php

namespace App;

use App\Http\Controllers\TokenController;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['masp'];
    //public $perPage = 10;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }



    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function logs()
    {
        return $this->hasMany(Logtrash::class, 'user_masp', 'masp');
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
