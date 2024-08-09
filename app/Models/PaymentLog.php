<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_no',
        'owner_type',
        'owner_id',
        'client_type',
        'client_id',
        'currency',
        'amount',
        'type',
        'payment_tool',
        'status'
    ];

    public function owner()
    {
        return $this->morphTo();
    }

}
