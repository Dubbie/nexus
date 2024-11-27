<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Insurer extends Model
{
    protected $fillable = [
        'name',
        'short_name'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected static function booted(): void
    {
        static::created(function (Insurer $insurer) {
            // Log the insurer creation
            ActivityLog::create([
                'user_id' => Auth::id() ?? null,
                'action' => ActivityLog::ACTION_CREATED,
                'target_type' => self::class,
                'target_id' => $insurer->id,
                'required_permission' => 'view insurers'
            ]);
        });
    }
}
