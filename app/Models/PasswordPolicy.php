<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'min_length',
        'require_uppercase',
        'require_lowercase',
        'require_numeric',
        'require_symbol',
        'history_depth',
        'expiry_days',
        'lockout_threshold',
        'enabled',
    ];

    protected $casts = [
        'require_uppercase' => 'boolean',
        'require_lowercase' => 'boolean',
        'require_numeric' => 'boolean',
        'require_symbol' => 'boolean',
        'enabled' => 'boolean',
    ];
}
