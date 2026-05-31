<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubsidizedAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'allocation_batch_id',
        'product_name',
        'total_quantity', 
        'state_name',
        'state_quota',    
        'remaining_quota', 
        'news_source',    
        'is_active'
    ];

    /**
     * Virtual Attribute: Calculates percentage left in the state quota.
     */
    public function getPercentRemainingAttribute()
    {
        if ($this->state_quota <= 0) return 0;
        return round(($this->remaining_quota / $this->state_quota) * 100, 1);
    }

    public function batch() {
        return $this->belongsTo(AllocationBatch::class, 'allocation_batch_id');
    }
}