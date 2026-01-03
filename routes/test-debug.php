<?php

use Illuminate\Support\Facades\Route;
use App\Models\Client;

Route::get('/test-user-data', function() {
    // Get first client for testing
    $user = Client::first();
    
    if (!$user) {
        return response()->json(['error' => 'No client found']);
    }
    
    // Prepare data exactly as controller does
    $userContext = [];
    
    // Wallet balance
    $userContext['wallet_balance'] = $user->wallet_balance ?? 0;
    $userContext['currency'] = $user->currency ?? 'USD';
    
    // Recent invoices (last 5)
    $recentInvoices = $user->invoices()->latest()->take(5)->get();
    $userContext['recent_invoices'] = $recentInvoices->map(function($invoice) {
        return [
            'id' => $invoice->id,
            'amount' => $invoice->total,
            'status' => $invoice->status,
            'date' => $invoice->created_at->format('Y-m-d')
        ];
    })->toArray();
    
    // Recent wallet transactions (last 10)
    $recentTransactions = $user->walletTransactions()->latest()->take(10)->get();
    $userContext['recent_transactions'] = $recentTransactions->map(function($transaction) {
        return [
            'id' => $transaction->id,
            'amount' => $transaction->amount,
            'type' => $transaction->type,
            'description' => $transaction->description ?? $transaction->type,
            'date' => $transaction->created_at->format('Y-m-d H:i')
        ];
    })->toArray();
    
    // Invoice summary
    $userContext['invoice_stats'] = [
        'total_count' => $user->invoices()->count(),
        'paid_count' => $user->invoices()->where('status', 'paid')->count(),
        'pending_count' => $user->invoices()->where('status', 'pending')->count(),
        'total_spent' => (float) $user->invoices()->where('status', 'paid')->sum('total')
    ];
    
    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email
        ],
        'context' => $userContext
    ]);
});
