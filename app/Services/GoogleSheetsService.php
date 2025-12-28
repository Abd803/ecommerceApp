<?php

namespace App\Services;

use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Log;

class GoogleSheetsService
{
    public function addOrder(Order $order)
    {
        try {
            $sheetId = \App\Models\Setting::where('key', 'google_spreadsheet_id')->value('value');
            
            // Fallback if config is missing (for safety)
            if (empty($sheetId)) {
                Log::warning('Google Sheet ID not configured.');
                return;
            }

            $row = [
                $order->order_number,
                $order->created_at->format('d/m/Y H:i'),
                $order->customer_name,
                $order->customer_firstname,
                $order->customer_phone,
                $order->customer_wilaya,
                $order->customer_wilaya,
                $order->product->name,
                $order->quantity,
                $order->product->price . ' DA',
                $order->total_price . ' DA',
                $order->status,
                $order->ip_address, // Added IP Column
                $order->selected_model // Add Selected Model
            ];
            
            Sheets::spreadsheet($sheetId)
                ->sheet('Commandes')
                ->append([$row]);
                
        } catch (Exception $e) {
            Log::error('Google Sheets Sync Error: ' . $e->getMessage());
        }
    }
}
