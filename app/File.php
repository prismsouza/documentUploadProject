<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    protected $fillable = ['name', 'extension', 'type', 'size', 'alias'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
