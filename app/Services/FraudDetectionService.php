<?php

namespace App\Services;

use App\Models\Order;
use App\Models\FraudLog;
use Illuminate\Http\Request;

class FraudDetectionService
{
    public function check(Request $request)
    {
        $score = 0;
        $reason = [];

        // 1. Check duplicate phone in last 24h
        $phoneCount = Order::where('customer_phone', $request->telephone)
            ->where('created_at', '>=', now()->subDay())
            ->count();
            
        if ($phoneCount >= 3) {
            $score += 50;
            $reason[] = 'duplicate_phone_24h';
        }

        // 2. Check IP frequency in last hour
        $ipCount = Order::where('ip_address', $request->ip())
            ->where('created_at', '>=', now()->subHour())
            ->count();
            
        if ($ipCount >= 5) {
            $score += 40;
            $reason[] = 'suspicious_ip_multiple_orders';
        }

        // 3. Check suspicious names
        if (preg_match('/test|fake|azerty|qwerty/i', $request->nom) || 
            preg_match('/test|fake|azerty|qwerty/i', $request->prenom)) {
            $score += 30;
            $reason[] = 'suspicious_name_pattern';
        }

        return [
            'score' => $score,
            'is_fraud' => $score >= 60,
            'reasons' => implode(',', $reason)
        ];
    }

    public function logFraud(Request $request, $reasons, $score, $orderId = null)
    {
        FraudLog::create([
            'order_id' => $orderId,
            'ip_address' => $request->ip(),
            'phone_number' => $request->phone,
            'fraud_reason' => $reasons ?: 'unknown',
            'fraud_score' => $score
        ]);
    }
}
