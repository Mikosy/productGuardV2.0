<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Eloquent\Relations\HasMany;



class AllocationBatch extends Model
{
    protected $fillable = ['product_name', 'total_quantity', 'news_source', 'market_price', 'subsidized_price', 'max_per_user'];

    public function subsidizedAllocations(): HasMany{
        return $this->hasMany(SubsidizedAllocation::class);
    }
}
