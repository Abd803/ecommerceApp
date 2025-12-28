<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'price', 'short_description', 'description', 
        'main_image', 'secondary_images', 'features', 'available_models', 'is_active', 
        'meta_title', 'meta_description'
    ];

    protected $casts = [
        'secondary_images' => 'array',
        'features' => 'array',
        'available_models' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
