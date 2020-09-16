<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logtrash extends Model
{
    protected $table = "logs";
    protected $fillable = ['user_masp', 'document_id', 'action', 'created_at'];

    public function documents()
    {
        return $this->belongsTo(Document::class);
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
