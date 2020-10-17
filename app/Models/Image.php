<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'id', 'title', 'description', 'name', 'old_name'
    ];

    public $incrementing = false;

    protected $keyType = 'string';
}
