<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogBoletim extends Model
{
    protected $table = "logs_boletim";
    protected $fillable = ['user_masp', 'boletim_id', 'action', 'created_at'];
    use SoftDeletes;


    public function boletins()
    {
        return $this->belongsTo(Boletim::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function path()
    {
        return route('boletins.logs', $this);
    }
}
