<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'category',
        'includes_tv',
        'includes_streaming_app',
        'includes_mobile_quota',
        'good_for_gaming',
        'good_for_streaming',
        'good_for_wfh',
        'min_users',
        'max_users',
        'best_for',
        'speed_mbps',
        'price_monthly',
        'device_ideal',
        'duration_months',
        'features',
        'whatsapp_order_url',
        'thumbnail',
        'banner_image',
        'banner_color_start',
        'banner_color_end',
        'short_description',
        'is_featured',
        'is_best_seller',
        'is_active',
    ];

    protected $casts = [
        'includes_tv' => 'boolean',
        'includes_streaming_app' => 'boolean',
        'includes_mobile_quota' => 'boolean',
        'good_for_gaming' => 'boolean',
        'good_for_streaming' => 'boolean',
        'good_for_wfh' => 'boolean',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_active' => 'boolean',
    ];
}