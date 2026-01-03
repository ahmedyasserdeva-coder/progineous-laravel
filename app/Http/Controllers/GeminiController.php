<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    protected $gemini;
    
    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }
    
    /**
     * Generate text
     */
    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:5000'
        ]);
        
        $response = $this->gemini->generateText($request->prompt);
        
        return response()->json([
            'success' => true,
            'response' => $response
        ]);
    }
    
    /**
     * Translate text
     */
    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000',
            'from' => 'required|string',
            'to' => 'required|string'
        ]);
        
        $translation = $this->gemini->translate(
            $request->text,
            $request->from,
            $request->to
        );
        
        return response()->json([
            'success' => true,
            'translation' => $translation
        ]);
    }
    
    /**
     * Summarize text
     */
    public function summarize(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:10000',
            'max_words' => 'nullable|integer|min:50|max:500'
        ]);
        
        $summary = $this->gemini->summarize(
            $request->text,
            $request->max_words ?? 200
        );
        
        return response()->json([
            'success' => true,
            'summary' => $summary
        ]);
    }
    
    /**
     * Generate FAQ
     */
    public function generateFAQ(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:500',
            'count' => 'nullable|integer|min:5|max:20'
        ]);
        
        $faq = $this->gemini->generateFAQ(
            $request->topic,
            $request->count ?? 10
        );
        
        return response()->json([
            'success' => true,
            'faq' => $faq
        ]);
    }
    
    /**
     * Check grammar
     */
    public function checkGrammar(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000'
        ]);
        
        $corrected = $this->gemini->checkGrammar($request->text);
        
        return response()->json([
            'success' => true,
            'original' => $request->text,
            'corrected' => $corrected
        ]);
    }
    
    /**
     * Chat (multi-turn conversation)
     */
    public function chat(Request $request)
    {
        try {
            $request->validate([
                'messages' => 'required|array',
                'messages.*.role' => 'required|in:user,model',
                'messages.*.content' => 'required|string'
            ]);
            
            // Get user info with related data
            $user = auth('client')->user();
            $userName = $user ? $user->first_name . ' ' . $user->last_name : 'User';
            
            // Get user context (wallet, invoices, transactions)
            $userContext = [];
            if ($user) {
                // Wallet balance (correct field name)
                $userContext['wallet_balance'] = $user->wallet_balance ?? 0;
                $userContext['currency'] = $user->currency ?? 'USD';
                
                // Recent invoices (last 5)
                $recentInvoices = $user->invoices()->latest()->take(5)->get();
                $userContext['recent_invoices'] = $recentInvoices->map(function($invoice) {
                    $items = [];
                    if ($invoice->order) {
                        // Get order items
                        $orderItems = $invoice->order->items ?? [];
                        foreach ($orderItems as $item) {
                            $description = '';
                            if (isset($item->service_type)) {
                                $description = $item->service_type;
                                if (isset($item->description)) {
                                    $description .= ' - ' . $item->description;
                                }
                            } elseif (isset($item->description)) {
                                $description = $item->description;
                            } elseif (isset($item->product_name)) {
                                $description = $item->product_name;
                            }
                            if ($description) {
                                $items[] = $description;
                            }
                        }
                    }
                    
                    return [
                        'id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number ?? '#' . $invoice->id,
                        'amount' => $invoice->total,
                        'status' => $invoice->status,
                        'date' => $invoice->created_at->format('Y-m-d'),
                        'items' => !empty($items) ? implode(', ', $items) : 'No details available'
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
            }
            
            $response = $this->gemini->chat($request->messages, $userName, $userContext);
            
            return response()->json([
                'success' => true,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Gemini Chat Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Error generating response: ' . $e->getMessage()
            ], 500);
        }
    }
}
