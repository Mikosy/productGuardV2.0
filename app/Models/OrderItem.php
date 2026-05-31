<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['item_tracking_id', 'status'];

    // Links the item back to its parent order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}