<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'client_id',
        'rating',
        'feedback',
        'category',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Scopes
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Helper to get rating label
    public static function getRatingLabel(int $rating): string
    {
        return match($rating) {
            1 => 'Very Poor',
            2 => 'Poor',
            3 => 'Average',
            4 => 'Good',
            5 => 'Excellent',
            default => 'Unknown',
        };
    }
}
