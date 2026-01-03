<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    private string $apiKey;
    private string $baseUrl;
    private string $model;
    
    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->baseUrl = env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta/models');
        $this->model = 'gemini-2.5-flash';
    }
    
    /**
     * Generate text using Gemini
     */
    public function generateText(string $prompt): string
    {
        $response = $this->makeRequest($prompt);
        
        if (!$response) {
            return 'Error generating response';
        }
        
        return $this->extractText($response);
    }
    
    /**
     * Start a chat conversation
     */
    public function chat(array $messages, string $userName = 'User', array $userContext = []): string
    {
        $contents = [];
        
        foreach ($messages as $msg) {
            $contents[] = [
                'role' => $msg['role'] ?? 'user',
                'parts' => [
                    ['text' => $msg['content']]
                ]
            ];
        }
        
        $response = $this->makeRequest(null, $contents, true, $userName, $userContext);
        
        if (!$response) {
            return 'Error generating response';
        }
        
        return $this->extractText($response);
    }
    
    /**
     * Chat with streaming support
     */
    public function chatStream(array $messages): string
    {
        return $this->chat($messages);
    }
    
    /**
     * Translate text
     */
    public function translate(string $text, string $from, string $to): string
    {
        $prompt = "Translate the following text from {$from} to {$to}. Return only the translation:\n\n{$text}";
        return $this->generateText($prompt);
    }
    
    /**
     * Summarize text
     */
    public function summarize(string $text, int $maxWords = 200): string
    {
        $prompt = "Summarize the following text in {$maxWords} words or less. Write in the same language as the text:\n\n{$text}";
        return $this->generateText($prompt);
    }
    
    /**
     * Generate FAQ
     */
    public function generateFAQ(string $topic, int $count = 10): array
    {
        $prompt = "Generate {$count} frequently asked questions with detailed answers about: {$topic}. Format as:\nQ: question\nA: answer";
        $response = $this->generateText($prompt);
        
        return [
            'raw' => $response,
            'parsed' => $this->parseFAQ($response)
        ];
    }
    
    /**
     * Check grammar and spelling
     */
    public function checkGrammar(string $text): string
    {
        $prompt = "Check and correct any grammar, spelling, or punctuation errors in the following text. Return only the corrected version without explanations:\n\n{$text}";
        return $this->generateText($prompt);
    }
    
    /**
     * Generate content
     */
    public function generateContent(string $prompt, array $options = []): string
    {
        return $this->generateText($prompt);
    }
    
    /**
     * Make API request
     */
    private function makeRequest(?string $prompt = null, ?array $contents = null, bool $useSystemInstruction = false, string $userName = 'User', array $userContext = []): ?array
    {
        // Use generateContent instead of streamGenerateContent for faster response
        $endpoint = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";
        
        $payload = [
            'contents' => $contents ?? [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 2048,
                'topP' => 0.95,
                'topK' => 40
            ]
        ];
        
        // Add system instruction for chat
        if ($useSystemInstruction) {
            $contextInfo = '';
            
            if (!empty($userContext)) {
                $contextInfo = "\n\nUser Account Information:";
                
                // Wallet info
                if (isset($userContext['wallet_balance'])) {
                    $currency = $userContext['currency'] ?? 'USD';
                    $balance = number_format((float)$userContext['wallet_balance'], 2);
                    $contextInfo .= "\n- Wallet Balance: {$balance} {$currency}";
                }
                
                // Invoice stats
                if (isset($userContext['invoice_stats'])) {
                    $stats = $userContext['invoice_stats'];
                    $totalSpent = number_format((float)$stats['total_spent'], 2);
                    $contextInfo .= "\n- Total Invoices: {$stats['total_count']}";
                    $contextInfo .= "\n- Paid Invoices: {$stats['paid_count']}";
                    $contextInfo .= "\n- Pending Invoices: {$stats['pending_count']}";
                    $contextInfo .= "\n- Total Spent: {$totalSpent} {$currency}";
                }
                
                // Recent invoices
                if (!empty($userContext['recent_invoices'])) {
                    $contextInfo .= "\n\nRecent Invoices:";
                    foreach ($userContext['recent_invoices'] as $invoice) {
                        $invoiceNum = $invoice['invoice_number'] ?? '#' . $invoice['id'];
                        $contextInfo .= "\n- Invoice {$invoiceNum}: {$invoice['amount']} {$currency} ({$invoice['status']}) - {$invoice['date']}";
                        if (!empty($invoice['items'])) {
                            $contextInfo .= "\n  Items: {$invoice['items']}";
                        }
                    }
                }
                
                // Recent transactions
                if (!empty($userContext['recent_transactions'])) {
                    $contextInfo .= "\n\nRecent Wallet Transactions:";
                    foreach ($userContext['recent_transactions'] as $transaction) {
                        $contextInfo .= "\n- {$transaction['date']}: {$transaction['type']} {$transaction['amount']} {$currency} - {$transaction['description']}";
                    }
                }
            }
            
            $payload['systemInstruction'] = [
                'parts' => [
                    ['text' => "You are ProGineous AI, a professional and friendly customer service representative developed by ProGineous. Your role is to assist {$userName} with their account inquiries in a warm, helpful, and professional manner.

PERSONALITY GUIDELINES:
- Be warm, friendly, and approachable while maintaining professionalism
- Use polite language like 'I'd be happy to help', 'Certainly', 'My pleasure'
- Show empathy and understanding towards customer needs
- Be patient and clear in your explanations
- Use positive language and avoid negative phrasing
- Address the user by name naturally when appropriate
- Thank the user when appropriate
- Offer additional assistance at the end of responses

COMMUNICATION STYLE:
- Keep responses clear, concise, and well-organized
- Use bullet points or numbered lists for multiple items
- Explain technical terms in simple language
- Be proactive in offering relevant information
- Use emojis sparingly and professionally (✓, 💰, 📄, etc.)

IMPORTANT RULES:{$contextInfo}

When asked about account information:
- Use ONLY the exact data provided above
- Never make up or guess numbers
- Format numbers clearly with currency symbols
- Present information in an organized, easy-to-read format
- If data shows specific amounts, report them exactly as shown

HUMAN SUPPORT HANDLING:
When the user requests to speak with a human, real support, customer service representative, or indicates they need human assistance:
1. Respond warmly and professionally
2. Include the special marker: [OPEN_INTERCOM]
3. Explain that you're connecting them to a live support agent
4. Thank them for their patience

Example responses:
- Arabic: \"بالطبع! يسعدني توصيلك بأحد ممثلي خدمة العملاء لدينا الآن. [OPEN_INTERCOM] جاري فتح نافذة الدعم المباشر... شكراً لتواصلك معنا!\"
- English: \"Certainly! I'd be happy to connect you with one of our live support representatives now. [OPEN_INTERCOM] Opening the live support chat... Thank you for reaching out!\"

Always respond in the user's language (Arabic or English) with proper grammar and professionalism. Your goal is to provide excellent customer service that makes users feel valued and well-assisted."]
                ]
            ];
        }
        
        try {
            $response = Http::timeout(30)
                ->connectTimeout(5)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($endpoint, $payload);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            logger()->error('Gemini API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return null;
        } catch (\Exception $e) {
            logger()->error('Gemini API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return null;
        }
    }
    
    /**
     * Extract text from response
     */
    private function extractText(array $response): string
    {
        // For non-streaming response
        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            return trim($response['candidates'][0]['content']['parts'][0]['text']);
        }
        
        // For streaming response (array of chunks)
        $fullText = '';
        if (isset($response) && is_array($response)) {
            foreach ($response as $chunk) {
                if (isset($chunk['candidates'][0]['content']['parts'][0]['text'])) {
                    $fullText .= $chunk['candidates'][0]['content']['parts'][0]['text'];
                }
            }
        }
        
        return trim($fullText);
    }
    
    /**
     * Parse FAQ response
     */
    private function parseFAQ(string $response): array
    {
        $faqs = [];
        $lines = explode("\n", $response);
        $currentQ = null;
        $currentA = '';
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            if (preg_match('/^(Q:|Question \d+:|\d+\.)\s*(.+)$/i', $line, $matches)) {
                if ($currentQ) {
                    $faqs[] = [
                        'question' => $currentQ,
                        'answer' => trim($currentA)
                    ];
                }
                
                $currentQ = trim($matches[2] ?? $line);
                $currentA = '';
            } elseif (preg_match('/^(A:|Answer:)\s*(.+)$/i', $line, $matches)) {
                $currentA = trim($matches[2] ?? $line);
            } else if ($currentQ) {
                $currentA .= ' ' . $line;
            }
        }
        
        if ($currentQ) {
            $faqs[] = [
                'question' => $currentQ,
                'answer' => trim($currentA)
            ];
        }
        
        return $faqs;
    }
}
