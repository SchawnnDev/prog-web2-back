<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'id', 'title', 'description', 'old_name', 'path'
    ];

    public $incrementing = false;

    protected $keyType = 'string';
}
