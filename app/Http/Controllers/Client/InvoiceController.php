<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\ArabicHelper;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoiceController extends Controller
{
    public function index()
    {
        $client = auth()->guard('client')->user();
        
        $invoices = Invoice::where('client_id', $client->id)
            ->with('order')
            ->orderBy('invoice_date', 'desc')
            ->paginate(15);
        
        return view('frontend.client.invoices.index', compact('invoices'));
    }
    
    public function show($id)
    {
        $client = auth()->guard('client')->user();
        
        $invoice = Invoice::where('client_id', $client->id)
            ->with('order', 'order.items', 'client', 'payments')
            ->findOrFail($id);
        
        return view('frontend.client.invoices.show', compact('invoice'));
    }
    
    public function download($id)
    {
        $client = auth()->guard('client')->user();
        
        $invoice = Invoice::where('client_id', $client->id)
            ->with('order', 'order.items', 'client', 'payments')
            ->findOrFail($id);
        
        try {
            // Generate QR code as SVG (no extension needed)
            $qrCode = base64_encode(QrCode::format('svg')
                ->size(120)
                ->margin(0)
                ->errorCorrection('H')
                ->generate(route('client.invoices.show', $invoice->id)));
            
            $qrFormat = 'svg';
        } catch (\Exception $e) {
            // Fallback: generate simple text-based identifier
            $qrCode = null;
            $qrFormat = null;
        }
        
        $pdf = Pdf::loadView('frontend.client.invoices.pdf', compact('invoice', 'qrCode', 'qrFormat'))
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'DejaVu Sans')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isFontSubsettingEnabled', true);
        
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
