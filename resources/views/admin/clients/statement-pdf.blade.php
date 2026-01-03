<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('crm.account_statement') }} - {{ $client->first_name }} {{ $client->last_name }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            background-color: #1e293b;
            color: white;
            padding: 25px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }
        .header p {
            opacity: 0.8;
            font-size: 12px;
        }
        .summary-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .summary-table td {
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }
        .summary-label {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 16px;
            font-weight: bold;
        }
        .green { color: #059669; }
        .red { color: #dc2626; }
        
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            padding: 10px 15px;
            background-color: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.data-table th {
            background-color: #f9fafb;
            padding: 10px 12px;
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
            font-size: 10px;
            font-weight: bold;
            color: #4b5563;
            border-bottom: 1px solid #e5e7eb;
        }
        table.data-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
        }
        .text-right {
            text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};
        }
        .badge {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-green { background-color: #d1fae5; color: #065f46; }
        .badge-amber { background-color: #fef3c7; color: #92400e; }
        .badge-red { background-color: #fee2e2; color: #991b1b; }
        .badge-gray { background-color: #f3f4f6; color: #374151; }
        .badge-purple { background-color: #ede9fe; color: #5b21b6; }
        
        .text-green { color: #059669; }
        .text-red { color: #dc2626; }
        .text-gray { color: #9ca3af; }
        .text-blue { color: #2563eb; }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
        .no-data {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
        }
        
        /* Digital Signature Section - New Page */
        .signature-page {
            page-break-before: always;
        }
        .signature-section {
            margin-top: 50px;
            padding: 30px;
            border: 3px solid #1e293b;
            background-color: #f8fafc;
        }
        .signature-header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
        }
        .signature-content {
            width: 100%;
        }
        .signature-content td {
            vertical-align: top;
            padding: 10px;
        }
        .qr-code-container {
            text-align: center;
            width: 140px;
        }
        .qr-code-container img {
            width: 120px;
            height: 120px;
            border: 2px solid #1e293b;
            padding: 5px;
            background-color: white;
        }
        .signature-info {
            font-size: 10px;
        }
        .signature-info-row {
            padding: 5px 0;
            border-bottom: 1px dashed #e5e7eb;
        }
        .signature-info-row:last-child {
            border-bottom: none;
        }
        .signature-label {
            color: #6b7280;
            font-size: 9px;
        }
        .signature-value {
            font-weight: bold;
            color: #1f2937;
            font-size: 10px;
        }
        .document-id {
            font-family: monospace;
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
            background-color: #e5e7eb;
            padding: 5px 10px;
            letter-spacing: 2px;
        }
        .verification-note {
            text-align: center;
            font-size: 8px;
            color: #6b7280;
            margin-top: 10px;
            font-style: italic;
        }
        
        .info-table {
            width: 100%;
            margin-bottom: 25px;
        }
        .info-table > tbody > tr > td {
            width: 50%;
            vertical-align: top;
            padding: 5px;
        }
        .info-box {
            border: 1px solid #e5e7eb;
        }
        .info-box-title {
            background-color: #f3f4f6;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 12px;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-box-content {
            padding: 0;
        }
        .info-row-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-row-table td {
            padding: 8px 15px;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-row-table td.label {
            width: 35%;
            background-color: #fafafa;
            font-weight: bold;
            color: #6b7280;
            font-size: 10px;
        }
        .info-row-table td.value {
            color: #1f2937;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ __('crm.account_statement') }}</h1>
        <p>{{ __('crm.generated_on') }}: {{ now()->format('M d, Y h:i A') }}</p>
    </div>

    <!-- Client Information - Two Columns using Tables -->
    <table class="info-table">
        <tr>
            <!-- Personal Information -->
            <td>
                <div class="info-box">
                    <div class="info-box-title">{{ __('crm.personal_information') }}</div>
                    <div class="info-box-content">
                        <table class="info-row-table">
                            <tr>
                                <td class="label">{{ __('crm.first_name') }}</td>
                                <td class="value">{{ $client->first_name }}</td>
                            </tr>
                            <tr>
                                <td class="label">{{ __('crm.last_name') }}</td>
                                <td class="value">{{ $client->last_name }}</td>
                            </tr>
                            <tr>
                                <td class="label">{{ __('crm.username') }}</td>
                                <td class="value">{{ '@' . $client->username }}</td>
                            </tr>
                            <tr>
                                <td class="label">{{ __('crm.email_address') }}</td>
                                <td class="value">{{ $client->email }}</td>
                            </tr>
                            <tr>
                                <td class="label">{{ __('crm.phone_number') }}</td>
                                <td class="value">{{ $client->phone ?? '-' }}</td>
                            </tr>
                            @if($client->company_name)
                            <tr>
                                <td class="label">{{ __('crm.company_name') }}</td>
                                <td class="value">{{ $client->company_name }}</td>
                            </tr>
                            @endif
                            @if($client->tax_number)
                            <tr>
                                <td class="label">{{ __('crm.tax_number') }}</td>
                                <td class="value">{{ $client->tax_number }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </td>

            <!-- Address Information -->
            <td>
                <div class="info-box">
                    <div class="info-box-title">{{ __('crm.address_information') }}</div>
                    <div class="info-box-content">
                        <table class="info-row-table">
                            <tr>
                                <td class="label">{{ __('crm.address_1') }}</td>
                                <td class="value">{{ $client->address1 ?? '-' }}</td>
                            </tr>
                            @if($client->address2)
                            <tr>
                                <td class="label">{{ __('crm.address_2') }}</td>
                                <td class="value">{{ $client->address2 }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="label">{{ __('crm.city') }}</td>
                                <td class="value">{{ $client->city ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">{{ __('crm.state') }}</td>
                                <td class="value">{{ $client->state ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">{{ __('crm.postcode') }}</td>
                                <td class="value">{{ $client->postcode ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">{{ __('crm.country') }}</td>
                                <td class="value">{{ $client->country ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Summary -->
    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-label">{{ __('crm.total_invoiced') }}</div>
                <div class="summary-value">${{ number_format($totalInvoiced, 2) }}</div>
            </td>
            <td>
                <div class="summary-label">{{ __('crm.total_paid') }}</div>
                <div class="summary-value green">${{ number_format($totalPaid, 2) }}</div>
            </td>
            <td>
                <div class="summary-label">{{ __('crm.total_unpaid') }}</div>
                <div class="summary-value red">${{ number_format($totalUnpaid, 2) }}</div>
            </td>
            <td>
                <div class="summary-label">{{ __('crm.balance_due') }}</div>
                <div class="summary-value {{ $balance > 0 ? 'red' : 'green' }}">${{ number_format($balance, 2) }}</div>
            </td>
        </tr>
    </table>

    <!-- Invoices -->
    <div class="section">
        <div class="section-title">{{ __('crm.invoices') }}</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('crm.invoice_number') }}</th>
                    <th>{{ __('crm.date') }}</th>
                    <th>{{ __('crm.due_date') }}</th>
                    <th>{{ __('crm.status') }}</th>
                    <th class="text-right">{{ __('crm.subtotal') }}</th>
                    <th class="text-right">{{ __('crm.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    @php
                        $badgeClass = match($invoice->status) {
                            'paid' => 'badge-green',
                            'unpaid' => 'badge-amber',
                            'overdue' => 'badge-red',
                            'cancelled' => 'badge-gray',
                            'refunded' => 'badge-purple',
                            default => 'badge-gray'
                        };
                    @endphp
                    <tr>
                        <td><span class="text-blue">{{ $invoice->invoice_number }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ ucfirst($invoice->status) }}</span></td>
                        <td class="text-right">${{ number_format($invoice->subtotal, 2) }}</td>
                        <td class="text-right"><strong>${{ number_format($invoice->total, 2) }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="no-data">{{ __('crm.no_invoices_found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Transactions -->
    <div class="section">
        <div class="section-title">{{ __('crm.transactions') }}</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('crm.date') }}</th>
                    <th>{{ __('crm.gateway') }}</th>
                    <th>{{ __('crm.transaction_id') }}</th>
                    <th>{{ __('crm.invoice') }}</th>
                    <th>{{ __('crm.status') }}</th>
                    <th class="text-right">{{ __('crm.amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y H:i') }}</td>
                        <td>{{ ucfirst($transaction->gateway ?? 'N/A') }}</td>
                        <td style="font-size: 9px;">{{ $transaction->transaction_id ?? 'N/A' }}</td>
                        <td>
                            @if($transaction->invoice_number)
                                <span class="text-blue">{{ $transaction->invoice_number }}</span>
                            @else
                                <span class="text-gray">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $transaction->status == 'completed' ? 'badge-green' : 'badge-amber' }}">
                                {{ ucfirst($transaction->status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="text-right {{ $transaction->status == 'completed' ? 'text-green' : '' }}">
                            <strong>${{ number_format($transaction->amount, 2) }}</strong>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="no-data">{{ __('crm.no_transactions_found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Digital Signature Section - New Page -->
    <div class="signature-page">
        <div class="signature-section">
            <div class="signature-header">
                🔐 {{ __('crm.digital_signature') }}
            </div>
            <table class="signature-content">
                <tr>
                    <td class="qr-code-container" style="width: 200px; text-align: center;">
                        <img src="{{ $qrCode }}" alt="QR Code" style="width: 150px; height: 150px; border: 3px solid #1e293b; padding: 8px; background-color: white;">
                        <div style="margin-top: 10px; font-size: 10px; color: #6b7280;">{{ __('crm.scan_to_verify') }}</div>
                    </td>
                    <td class="signature-info" style="padding-left: 30px;">
                        <div class="signature-info-row" style="padding: 8px 0; border-bottom: 1px dashed #e5e7eb;">
                            <div class="signature-label" style="color: #6b7280; font-size: 10px;">{{ __('crm.document_id') }}</div>
                            <div class="document-id" style="font-family: monospace; font-size: 14px; font-weight: bold; color: #1e293b; background-color: #e5e7eb; padding: 8px 12px; letter-spacing: 3px; margin-top: 5px;">{{ $documentId }}</div>
                        </div>
                        <div class="signature-info-row" style="padding: 8px 0; border-bottom: 1px dashed #e5e7eb;">
                            <div class="signature-label" style="color: #6b7280; font-size: 10px;">{{ __('crm.issued_to') }}</div>
                            <div class="signature-value" style="font-weight: bold; color: #1f2937; font-size: 12px;">{{ $client->first_name }} {{ $client->last_name }}</div>
                        </div>
                        <div class="signature-info-row" style="padding: 8px 0; border-bottom: 1px dashed #e5e7eb;">
                            <div class="signature-label" style="color: #6b7280; font-size: 10px;">{{ __('crm.client_email') }}</div>
                            <div class="signature-value" style="font-weight: bold; color: #1f2937; font-size: 12px;">{{ $client->email }}</div>
                        </div>
                        <div class="signature-info-row" style="padding: 8px 0; border-bottom: 1px dashed #e5e7eb;">
                            <div class="signature-label" style="color: #6b7280; font-size: 10px;">{{ __('crm.generation_date') }}</div>
                            <div class="signature-value" style="font-weight: bold; color: #1f2937; font-size: 12px;">{{ $generatedAt }}</div>
                        </div>
                        <div class="signature-info-row" style="padding: 8px 0; border-bottom: 1px dashed #e5e7eb;">
                            <div class="signature-label" style="color: #6b7280; font-size: 10px;">{{ __('crm.issued_by') }}</div>
                            <div class="signature-value" style="font-weight: bold; color: #1f2937; font-size: 12px;">{{ config('app.name') }}</div>
                        </div>
                        <div class="signature-info-row" style="padding: 8px 0;">
                            <div class="signature-label" style="color: #6b7280; font-size: 10px;">{{ __('crm.document_status') }}</div>
                            <div class="signature-value" style="font-weight: bold; color: #059669; font-size: 14px;">✓ {{ __('crm.verified_authentic') }}</div>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="verification-note" style="text-align: center; font-size: 10px; color: #6b7280; margin-top: 20px; font-style: italic; padding: 15px; background-color: #f1f5f9; border-radius: 5px;">
                {{ __('crm.qr_verification_note') }}
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            {{ config('app.name') }} &bull; {{ __('crm.account_statement') }} &bull; {{ now()->format('Y') }}
        </div>
    </div>
</body>
</html>
