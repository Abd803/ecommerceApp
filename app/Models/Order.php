<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'product_id', 'quantity', 'selected_model', 'customer_name', 'customer_firstname', 
        'customer_phone', 'customer_wilaya', 'total_price', 'status', 
        'admin_notes', 'ip_address', 'user_agent', 'utm_source', 'utm_campaign', 'is_suspected_fraud'
    ];

    protected $casts = [
        'is_suspected_fraud' => 'boolean',
        'total_price' => 'decimal:2'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function fraudLogs()
    {
        return $this->hasMany(FraudLog::class);
    }
}
