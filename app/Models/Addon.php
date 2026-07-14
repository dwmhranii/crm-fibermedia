<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'category',
        'price',
        'pricing_type',
        'duration_months',
        'short_description',
        'description',
        'features',
        'device_ideal',
        'best_for',
        'thumbnail',
        'banner_image',
        'banner_color_start',
        'banner_color_end',
        'whatsapp_url',
        'is_featured',
        'is_best_seller',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_active' => 'boolean',
    ];
}