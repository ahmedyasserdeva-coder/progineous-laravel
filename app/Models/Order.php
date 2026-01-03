<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_id',
        'product_id',
        'order_number',
        'domain_name',
        'amount',
        'subtotal',
        'discount',
        'tax',
        'total',
        'currency',
        'status',
        'payment_status',
        'payment_method',
        'payment_gateway_id',
        'billing_cycle',
        'next_due_date',
        'order_details',
        'coupon_code',
        'coupon_discount',
        'notes',
        'paid_at',
        'completed_at',
    ];

    protected $casts = [
        'order_details' => 'array',
        'amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'next_due_date' => 'datetime',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Helper Methods
    public function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotal()
    {
        $this->subtotal = $this->items->sum('total');
        $this->total = $this->subtotal - $this->discount + $this->tax - $this->coupon_discount;
        return $this->total;
    }

    public function markAsPaid()
    {
        $this->payment_status = 'paid';
        $this->paid_at = now();
        $this->save();
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->completed_at = now();
        $this->save();
    }
}
