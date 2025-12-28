<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraudLog extends Model
{
    protected $fillable = [
        'order_id', 'ip_address', 'phone_number', 'fraud_reason', 'fraud_score'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
