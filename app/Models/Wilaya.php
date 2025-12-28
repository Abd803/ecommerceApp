<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    protected $fillable = ['code', 'name', 'delivery_fee'];

    protected $casts = [
        'delivery_fee' => 'decimal:2'
    ];
}
