<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\VerifiedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountStatementController extends Controller
{
    /**
     * Show account statement page
     */
    public function index()
    {
        $client = Auth::guard('client')->user();
        
        // Get all invoices for the client
        $invoices = DB::table('invoices')
            ->where('client_id', $client->id)
            ->orderBy('invoice_date', 'desc')
            ->get();

        // Get all payments/transactions
        $transactions = DB::table('payments')
            ->where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.client.account-statement.index', compact('client', 'invoices', 'transactions'));
    }

    /**
     * Download account statement as PDF
     */
    public function downloadPdf()
    {
        $client = Auth::guard('client')->user();
        
        // Get all invoices for the client
        $invoices = DB::table('invoices')
            ->where('client_id', $client->id)
            ->orderBy('invoice_date', 'desc')
            ->get();

        // Get all payments/transactions
        $transactions = DB::table('payments')
            ->where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalInvoiced = $invoices->sum('total');
        $totalPaid = $invoices->where('status', 'paid')->sum('total');
        $totalUnpaid = $invoices->whereIn('status', ['unpaid', 'overdue'])->sum('total');
        $balance = $totalInvoiced - $totalPaid;

        // Generate unique document signature
        $documentId = strtoupper(substr(md5($client->id . time() . uniqid()), 0, 12));
        $generatedAt = now()->format('Y-m-d H:i:s');
        
        // Create QR Code with direct verification URL
        $verificationUrl = url('/verify/' . $documentId);
        
        // Generate QR Code as base64 image
        $qrOptions = new \chillerlan\QRCode\QROptions([
            'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => \chillerlan\QRCode\QRCode::ECC_M,
            'scale' => 5,
            'imageBase64' => true,
        ]);
        
        $qrCode = (new \chillerlan\QRCode\QRCode($qrOptions))->render($verificationUrl);

        $html = view('admin.clients.statement-pdf', compact(
            'client', 
            'invoices', 
            'transactions',
            'totalInvoiced',
            'totalPaid',
            'totalUnpaid',
            'balance',
            'qrCode',
            'documentId',
            'generatedAt'
        ))->render();

        $filename = 'statement_' . $client->username . '_' . date('Y-m-d') . '.pdf';
        
        // Create mPDF instance with Arabic support
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/temp'),
        ]);
        
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        
        $mpdf->WriteHTML($html);
        
        $pdfContent = $mpdf->Output($filename, 'S');
        
        // Generate document hash for verification
        $documentHash = hash('sha256', $pdfContent);
        
        // Create content hash from actual data for deep verification
        $invoicesData = $invoices->map(function($inv) {
            return [
                'invoice_number' => $inv->invoice_number,
                'total' => $inv->total,
                'status' => $inv->status,
                'date' => $inv->invoice_date,
            ];
        })->toArray();
        
        $transactionsData = $transactions->map(function($trans) {
            return [
                'transaction_id' => $trans->transaction_id ?? null,
                'amount' => $trans->amount,
                'gateway' => $trans->gateway ?? null,
                'status' => $trans->status ?? null,
            ];
        })->toArray();
        
        $contentHash = hash('sha256', json_encode([
            'document_id' => $documentId,
            'generated_at' => $generatedAt,
            'client_id' => $client->id,
            'total_invoiced' => $totalInvoiced,
            'total_paid' => $totalPaid,
            'balance' => $balance,
            'invoices' => $invoicesData,
            'transactions' => $transactionsData,
        ]));
        
        // Save document record for verification
        VerifiedDocument::create([
            'document_id' => $documentId,
            'client_id' => $client->id,
            'document_type' => 'statement',
            'document_hash' => $documentHash,
            'content_hash' => $contentHash,
            'total_invoiced' => $totalInvoiced,
            'balance' => $balance,
            'metadata' => [
                'client_name' => $client->first_name . ' ' . $client->last_name,
                'client_email' => $client->email,
                'invoices_count' => $invoices->count(),
                'transactions_count' => $transactions->count(),
                'total_paid' => $totalPaid,
                'total_unpaid' => $totalUnpaid,
                'invoices' => $invoicesData,
                'transactions' => $transactionsData,
            ],
            'generated_at' => now(),
        ]);
        
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
