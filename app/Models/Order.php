<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'allocation_id', 
        'quantity', 
        'amount_paid', 
        'payment_reference', 
        'status'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function allocation() { return $this->belongsTo(SubsidizedAllocation::class); }

    // shows this model is linked to Order item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function subsidizedAllocation()
    {
        // The second argument must be the EXACT column name in your orders table 
        // that points to the allocation (e.g., 'subsidized_allocation_id')
        return $this->belongsTo(SubsidizedAllocation::class, 'allocation_batch_id');
    }
}
