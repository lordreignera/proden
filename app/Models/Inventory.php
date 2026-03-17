<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['product_id', 'quantity_produced', 'quantity_sold', 'quantity_available', 'transaction_type', 'notes', 'transaction_date'];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
