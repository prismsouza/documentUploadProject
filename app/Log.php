<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    protected $table = "logs";
    protected $fillable = ['user_masp', 'document_id', 'boletim_id', 'action', 'created_at'];
    use SoftDeletes;

    public function documents()
    {
        return $this->belongsTo(Document::class);
    }

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
        return route('documents.logs', $this);
    }
}
