<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['name', 'extension', 'type', 'size'];
    public $timestamps = false;

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
