<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coverage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'district',
        'city',
        'sort_order',
        'is_active',
        'lat',
        'lng',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'lat' => 'float',
        'lng' => 'float',
    ];
}