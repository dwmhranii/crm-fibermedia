<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhyCard extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'icon',
        'bg_color',
        'text_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}