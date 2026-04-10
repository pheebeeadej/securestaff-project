<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'month',
        'gross_pay',
        'deductions',
        'net_pay',
    ];

    protected $casts = [
        'month' => 'date:Y-m-01',
        'gross_pay' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_pay' => 'decimal:2',
    ];
}
