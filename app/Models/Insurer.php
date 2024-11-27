<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurer extends Model
{
    protected $fillable = [
        'name',
        'short_name'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
