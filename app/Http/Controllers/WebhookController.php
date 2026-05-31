<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function handlePaystack(Request $request)
    {

        // use this on development environment
        // 1. Security Check: Only enforce signature validation in production
        if (app()->environment('production')) {
            $paystackSignature = $request->header('x-paystack-signature');
            $secretKey = config('services.paystack.secret_key');

            if (!$paystackSignature || $paystackSignature !== hash_hmac('sha512', $request->getContent(), $secretKey)) {
                Log::warning('Unauthorized Webhook Attempt Detected', ['ip' => $request->ip()]);
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } else {
            // Log a note locally so you know the bypass worked safely
            Log::info('Local environment detected: Bypassing Webhook Signature Check.');
        }

        // and this on production
        // 1. Security Check: Strict cryptographic verification for live payments
        // $paystackSignature = $request->header('x-paystack-signature');
        // $secretKey = config('services.paystack.secret_key');

        // if (!$paystackSignature || $paystackSignature !== hash_hmac('sha512', $request->getContent(), $secretKey)) {
        //     Log::warning('Unauthorized Webhook Attempt Detected', ['ip' => $request->ip()]);
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        // 2. Parse the payload
        $payload = $request->all();
        
        // We only care about successful transactions
        if ($payload['event'] !== 'charge.success') {
            return response()->json(['message' => 'Event ignored'], 200);
        }

        $reference = $payload['data']['reference'];
        
        // 3. Find the associated order
        $order = Order::where('payment_reference', $reference)->first();

        if (!$order) {
            Log::error('Webhook Error: Order Reference Not Found', ['reference' => $reference]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 4. Process the Order Safely
        if ($order->status !== 'paid' && $order->status !== 'collected') {
            try {
                DB::transaction(function () use ($order) {
                    // Update Order Status
                    $order->update(['status' => 'paid']);
                    
                    // Deduct State Quota Balance
                    $order->allocation->decrement('remaining_quota', $order->quantity);
                    
                    // --- NEW: Dynamic Serial ID Minting Engine ---
                    // Clean user name into an alphanumeric uppercase string (e.g., "JOHN DOE" -> "JOHN")
                    $rawName = explode(' ', $order->user->name)[0]; 
                    $buyerName = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $rawName)); 
                    
                    // Grab the abbreviated state name (e.g., "Abia" -> "ABIA")
                    $stateName = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $order->allocation->state_name));
                    
                    // Loop through the precise volume purchased to stamp custom tracking strings
                    for ($i = 1; $i <= $order->quantity; $i++) {
                        // Generates standardized 3-digit strings: 001, 002, 040
                        $paddedIndex = str_pad($i, 3, '0', STR_PAD_LEFT); 
                        
                        $order->items()->create([
                            'item_tracking_id' => "{$buyerName}-{$stateName}-{$paddedIndex}",
                            'status' => 'paid'
                        ]);
                    }
                    
                    Log::info('Webhook & Item Tokens Processed Successfully', [
                        'reference' => $order->payment_reference,
                        'items_minted' => $order->quantity
                    ]);
                });
            } catch (\Exception $e) {
                Log::critical('Webhook Database Transaction Failed', [
                    'reference' => $reference,
                    'error' => $e->getMessage()
                ]);
                return response()->json(['message' => 'Database failure'], 500);
            }
        }
        

        // 5. Tell Paystack you received the data successfully
        return response()->json(['message' => 'Webhook Handled Successfully'], 200);
    }

    
}
