<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'owner_type', 'owner_id', 'total_amount', 'status',"paid","address_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();

        static::updated(function ($order) {
            if ($order->isDirty('status')) {

                // Fetch the webhook URL from the database or configuration
                $webhookUrl = env('WEBHOOK_URL'); // Or fetch from database
                // $webhookUrl = \App\Models\Webhook::first()->url;

                $payload = [
                    'order_id' => $order->id,
                    'new_status' => $order->status,
                ];

                try {
                    $response = \Http::post("$webhookUrl", $payload);

                    if ($response->successful()) {
                        Log::info('Webhook sent successfully');
                    } else {
                        Log::error('Failed to send webhook', ['response' => $response->body()]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error sending webhook: ' . $e->getMessage());
                }
            }
        });
    }
}
