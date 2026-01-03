<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderRatingController extends Controller
{
    /**
     * Store a new rating for an order
     */
    public function store(Request $request, Order $order)
    {
        $client = Auth::guard('client')->user();
        
        // Verify the order belongs to the client
        if ($order->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.unauthorized_action'),
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'category' => 'nullable|string|in:checkout,support,product',
        ]);

        // Check if already rated
        $existingRating = OrderRating::where('order_id', $order->id)
            ->where('category', $validated['category'] ?? 'checkout')
            ->first();

        if ($existingRating) {
            // Update existing rating
            $existingRating->update([
                'rating' => $validated['rating'],
                'feedback' => $validated['feedback'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => __('frontend.rating_updated'),
                'rating' => $existingRating,
            ]);
        }

        // Create new rating
        $rating = OrderRating::create([
            'order_id' => $order->id,
            'client_id' => $client->id,
            'rating' => $validated['rating'],
            'feedback' => $validated['feedback'] ?? null,
            'category' => $validated['category'] ?? 'checkout',
        ]);

        return response()->json([
            'success' => true,
            'message' => __('frontend.rating_submitted'),
            'rating' => $rating,
        ]);
    }

    /**
     * Get rating for an order
     */
    public function show(Order $order)
    {
        $client = Auth::guard('client')->user();
        
        if ($order->client_id !== $client->id) {
            return response()->json([
                'success' => false,
                'message' => __('frontend.unauthorized_action'),
            ], 403);
        }

        $rating = OrderRating::where('order_id', $order->id)
            ->where('category', 'checkout')
            ->first();

        return response()->json([
            'success' => true,
            'rating' => $rating,
        ]);
    }
}
