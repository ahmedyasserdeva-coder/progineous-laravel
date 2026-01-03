<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'type',
        'product_name',
        'configuration',
        'unit_price',
        'quantity',
        'subtotal',
        'discount',
        'total',
        'status',
    ];

    protected $casts = [
        'configuration' => 'array',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }

    // Helper Methods
    public function calculateTotal()
    {
        $this->subtotal = $this->unit_price * $this->quantity;
        $this->total = $this->subtotal - $this->discount;
        return $this->total;
    }
}
