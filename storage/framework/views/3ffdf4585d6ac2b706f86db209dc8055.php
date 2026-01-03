<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #<?php echo e($invoice->invoice_number); ?></title>
    <?php
        // Helper function to fix Arabic text for PDF
        if (!function_exists('pdf_text')) {
            function pdf_text($key, $uppercase = false) {
                $text = __($key);
                if (app()->getLocale() == 'ar' && class_exists('\ArPHP\I18N\Arabic')) {
                    $arabic = new \ArPHP\I18N\Arabic();
                    return $arabic->utf8Glyphs($text);
                }
                return $uppercase ? strtoupper($text) : $text;
            }
        }
    ?>
    <style>
        * {
            font-family: 'DejaVu Sans', sans-serif;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #1f2937;
            margin: 0;
            padding: 20px;
            direction: <?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>;
            position: relative;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60pt;
            font-weight: bold;
            color: rgba(16, 185, 129, 0.3);
            text-transform: uppercase;
            white-space: nowrap;
            z-index: -1;
            pointer-events: none;
            border: 8px dashed rgba(16, 185, 129, 0.3);
            padding: 40px 80px;
            border-radius: 15px;
            letter-spacing: 8px;
        }
        .header {
            width: 100%;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }
        .header table { width: 100%; border-collapse: collapse; }
        .company-name { font-size: 20pt; font-weight: bold; color: #111827; margin-bottom: 8px; }
        .company-info { font-size: 8pt; color: #6b7280; line-height: 1.5; }
        .invoice-label { font-size: 9pt; text-transform: uppercase; color: #6b7280; letter-spacing: 1px; margin-bottom: 5px; }
        .invoice-number { font-size: 26pt; font-weight: bold; color: #111827; }
        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 3px; font-size: 8pt; font-weight: 600; margin-top: 8px; text-transform: uppercase; }
        .status-paid { background-color: #d1fae5; color: #065f46; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        
        .info-section { width: 100%; margin-bottom: 25px; }
        .info-section table { width: 100%; border-collapse: collapse; }
        .info-title { font-size: 8pt; text-transform: uppercase; color: #6b7280; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 10px; }
        .info-name { font-size: 11pt; font-weight: 600; color: #111827; margin-bottom: 5px; }
        .info-detail { font-size: 9pt; color: #4b5563; margin-bottom: 3px; }
        .info-label { font-weight: 600; }
        
        .dates-section { width: 100%; margin-bottom: 25px; padding: 15px 0; background-color: #f9fafb; }
        .dates-section table { width: 100%; border-collapse: collapse; }
        .date-box { padding: 0 15px; text-align: center; }
        .date-label { font-size: 8pt; text-transform: uppercase; color: #6b7280; font-weight: 600; margin-bottom: 5px; }
        .date-value { font-size: 10pt; font-weight: 600; color: #111827; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; direction: <?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>; }
        .items-table thead { background-color: #f9fafb; border-top: 2px solid #e5e7eb; border-bottom: 2px solid #e5e7eb; }
        .items-table th { padding: 10px 8px; text-align: <?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>; font-size: 8pt; text-transform: uppercase; color: #6b7280; font-weight: 600; letter-spacing: 0.5px; }
        .items-table th.text-right { text-align: right; }
        .items-table th.text-left { text-align: left; }
        .items-table td { padding: 10px 8px; border-bottom: 1px solid #f3f4f6; font-size: 9pt; color: #1f2937; text-align: <?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>; }
        .items-table td.text-right { text-align: right; }
        .items-table td.text-left { text-align: left; }
        .item-name { font-weight: 600; color: #111827; }
        .item-description { font-size: 8pt; color: #6b7280; margin-top: 2px; }
        
        .summary-container { width: 100%; margin-top: 20px; }
        .summary-table { width: 280px; float: <?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>; border-collapse: collapse; }
        .summary-table td { padding: 8px 0; font-size: 9pt; }
        .summary-label { color: #6b7280; text-align: <?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>; }
        .summary-value { font-weight: 600; color: #111827; text-align: <?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>; }
        .summary-total td { padding-top: 12px; border-top: 2px solid #111827; font-size: 11pt; font-weight: bold; color: #111827; }
        .summary-paid td { background-color: #d1fae5; color: #065f46; font-weight: 600; padding: 8px 10px; }
        .summary-balance td { background-color: #fee2e2; color: #991b1b; font-weight: 600; padding: 8px 10px; }
        
        .notes { background-color: #f9fafb; padding: 15px; margin-bottom: 20px; border-left: 3px solid #6b7280; }
        .notes-label { font-size: 8pt; text-transform: uppercase; color: #6b7280; font-weight: 600; margin-bottom: 5px; }
        .notes-text { font-size: 9pt; color: #4b5563; }
        
        .transactions-section { margin-top: 30px; padding-top: 20px; border-top: 2px solid #e5e7eb; }
        .section-title { font-size: 9pt; text-transform: uppercase; color: #6b7280; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 15px; }
        
        .signature-section {
            width: 100%;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .signature-container {
            width: 300px;
            float: <?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>;
            text-align: center;
            border: 2px solid #e5e7eb;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9fafb;
        }
        .qr-container {
            width: 200px;
            float: <?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>;
            text-align: center;
            border: 2px solid #e5e7eb;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9fafb;
        }
        .qr-title {
            font-size: 9pt;
            font-weight: 600;
            color: #111827;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .qr-code-box {
            background: white;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
        }
        .qr-code-box img {
            display: block;
            width: 120px;
            height: 120px;
        }
        .qr-label {
            font-size: 7pt;
            color: #6b7280;
            margin-top: 8px;
        }
        .signature-hash {
            font-size: 7pt;
            color: #9ca3af;
            font-family: monospace;
            word-break: break-all;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        
        .footer { margin-top: 40px; padding-top: 15px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 8pt; color: #9ca3af; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <?php if($invoice->status === 'paid'): ?>
    <div class="watermark">
        <?php if(app()->getLocale() == 'ar'): ?>
            <?php echo pdf_text('frontend.paid'); ?>

        <?php else: ?>
            PAID
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="header">
        <table>
            <tr>
                <?php if(app()->getLocale() == 'ar'): ?>
                <td style="width: 50%; vertical-align: top;">
                    <img src="<?php echo e(public_path('logo/pro Gineous_logo.svg')); ?>" alt="<?php echo e(config('app.name')); ?>" style="height: 40px; margin-bottom: 10px;">
                    <div class="company-info">
                        <?php echo pdf_text('frontend.reg_no'); ?>: 90088 | <?php echo pdf_text('frontend.vat'); ?>: 755-552-334<br>
                        Bani Waldin Ihsanan Tower - 3rd Floor<br>
                        Mostafa Kamel Street, Beni Suef Center, Beni Suef Governorate
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="invoice-label"><?php echo pdf_text('frontend.invoice'); ?></div>
                    <div class="invoice-number">#<?php echo e($invoice->invoice_number); ?></div>
                    <?php if($invoice->status === 'paid'): ?>
                        <span class="status-badge status-paid"><?php echo pdf_text('frontend.paid'); ?></span>
                    <?php elseif($invoice->status === 'pending'): ?>
                        <span class="status-badge status-pending"><?php echo pdf_text('frontend.pending'); ?></span>
                    <?php elseif($invoice->status === 'cancelled'): ?>
                        <span class="status-badge status-cancelled"><?php echo pdf_text('frontend.cancelled'); ?></span>
                    <?php endif; ?>
                </td>
                <?php else: ?>
                <td style="width: 50%; vertical-align: top;">
                    <img src="<?php echo e(public_path('logo/pro Gineous_logo.svg')); ?>" alt="<?php echo e(config('app.name')); ?>" style="height: 40px; margin-bottom: 10px;">
                    <div class="company-info">
                        Registration No: 90088 | VAT: 755-552-334<br>
                        Bani Waldin Ihsanan Tower - 3rd Floor<br>
                        Mostafa Kamel Street, Beni Suef Center, Beni Suef Governorate
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top; text-align: right;">
                    <div class="invoice-label"><?php echo pdf_text('frontend.invoice', true); ?></div>
                    <div class="invoice-number">#<?php echo e($invoice->invoice_number); ?></div>
                    <?php if($invoice->status === 'paid'): ?>
                        <span class="status-badge status-paid"><?php echo pdf_text('frontend.paid', true); ?></span>
                    <?php elseif($invoice->status === 'pending'): ?>
                        <span class="status-badge status-pending"><?php echo pdf_text('frontend.pending', true); ?></span>
                    <?php elseif($invoice->status === 'cancelled'): ?>
                        <span class="status-badge status-cancelled"><?php echo pdf_text('frontend.cancelled', true); ?></span>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <?php if(app()->getLocale() == 'ar'): ?>
                <td style="width: 50%; vertical-align: top; padding-left: 20px;">
                    <div class="info-title"><?php echo pdf_text('frontend.pay_to'); ?></div>
                    <img src="<?php echo e(public_path('logo/pro Gineous_logo.svg')); ?>" alt="<?php echo e(config('app.name')); ?>" style="height: 30px; margin-bottom: 8px;">
                    <div class="info-detail"><span class="info-label"><?php echo pdf_text('frontend.reg_no'); ?>:</span> 90088</div>
                    <div class="info-detail"><span class="info-label"><?php echo pdf_text('frontend.vat'); ?>:</span> 755-552-334</div>
                    <div class="info-detail">Bani Waldin Ihsanan Tower - 3rd Floor<br>Mostafa Kamel Street, Beni Suef</div>
                </td>
                <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                    <div class="info-title"><?php echo pdf_text('frontend.invoiced_to'); ?></div>
                    <div class="info-name"><?php echo e($invoice->client->full_name ?? 'N/A'); ?></div>
                    <div class="info-detail"><?php echo e($invoice->client->email ?? 'N/A'); ?></div>
                    <?php if($invoice->client->phone): ?>
                    <div class="info-detail"><?php echo e($invoice->client->phone); ?></div>
                    <?php endif; ?>
                    <?php if($invoice->client->company_name): ?>
                    <div class="info-detail"><?php echo e($invoice->client->company_name); ?></div>
                    <?php endif; ?>
                </td>
                <?php else: ?>
                <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                    <div class="info-title"><?php echo pdf_text('frontend.invoiced_to', true); ?></div>
                    <div class="info-name"><?php echo e($invoice->client->full_name ?? 'N/A'); ?></div>
                    <div class="info-detail"><?php echo e($invoice->client->email ?? 'N/A'); ?></div>
                    <?php if($invoice->client->phone): ?>
                    <div class="info-detail"><?php echo e($invoice->client->phone); ?></div>
                    <?php endif; ?>
                    <?php if($invoice->client->company_name): ?>
                    <div class="info-detail"><?php echo e($invoice->client->company_name); ?></div>
                    <?php endif; ?>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="info-title"><?php echo pdf_text('frontend.pay_to', true); ?></div>
                    <img src="<?php echo e(public_path('logo/pro Gineous_logo.svg')); ?>" alt="<?php echo e(config('app.name')); ?>" style="height: 30px; margin-bottom: 8px;">
                    <div class="info-detail"><span class="info-label"><?php echo pdf_text('frontend.reg_no'); ?>:</span> 90088</div>
                    <div class="info-detail"><span class="info-label"><?php echo pdf_text('frontend.vat'); ?>:</span> 755-552-334</div>
                    <div class="info-detail">Bani Waldin Ihsanan Tower - 3rd Floor<br>Mostafa Kamel Street, Beni Suef</div>
                </td>
                <?php endif; ?>
            </tr>
        </table>
    </div>

    <div class="dates-section">
        <table>
            <tr>
                <?php if(app()->getLocale() == 'ar'): ?>
                <?php if($invoice->paid_at): ?>
                <td class="date-box" style="width: 33.33%;">
                    <div class="date-label"><?php echo pdf_text('frontend.paid_date'); ?></div>
                    <div class="date-value"><?php echo e($invoice->paid_at->format('M d, Y')); ?></div>
                </td>
                <?php endif; ?>
                <td class="date-box" style="width: 33.33%; <?php echo e($invoice->paid_at ? 'border-right: 1px solid #e5e7eb;' : ''); ?> border-left: 1px solid #e5e7eb;">
                    <div class="date-label"><?php echo pdf_text('frontend.due_date'); ?></div>
                    <div class="date-value"><?php echo e($invoice->due_date->format('M d, Y')); ?></div>
                </td>
                <td class="date-box" style="width: 33.33%;">
                    <div class="date-label"><?php echo pdf_text('frontend.invoice_date'); ?></div>
                    <div class="date-value"><?php echo e($invoice->invoice_date->format('M d, Y')); ?></div>
                </td>
                <?php else: ?>
                <td class="date-box" style="width: 33.33%;">
                    <div class="date-label"><?php echo pdf_text('frontend.invoice_date', true); ?></div>
                    <div class="date-value"><?php echo e($invoice->invoice_date->format('M d, Y')); ?></div>
                </td>
                <td class="date-box" style="width: 33.33%; border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb;">
                    <div class="date-label"><?php echo pdf_text('frontend.due_date', true); ?></div>
                    <div class="date-value"><?php echo e($invoice->due_date->format('M d, Y')); ?></div>
                </td>
                <?php if($invoice->paid_at): ?>
                <td class="date-box" style="width: 33.33%;">
                    <div class="date-label"><?php echo pdf_text('frontend.paid_date', true); ?></div>
                    <div class="date-value"><?php echo e($invoice->paid_at->format('M d, Y')); ?></div>
                </td>
                <?php endif; ?>
                <?php endif; ?>
            </tr>
        </table>
    </div>

    <?php if($invoice->order && $invoice->order->items->count() > 0): ?>
    <table class="items-table">
        <thead>
            <tr>
                <?php if(app()->getLocale() == 'ar'): ?>
                <th class="text-left" style="width: 20%;"><?php echo pdf_text('frontend.total'); ?></th>
                <th class="text-left" style="width: 20%;"><?php echo pdf_text('frontend.price'); ?></th>
                <th style="width: 10%;"><?php echo pdf_text('frontend.qty'); ?></th>
                <th style="width: 50%;"><?php echo pdf_text('frontend.item'); ?></th>
                <?php else: ?>
                <th style="width: 50%;"><?php echo pdf_text('frontend.item', true); ?></th>
                <th style="width: 10%;"><?php echo pdf_text('frontend.qty', true); ?></th>
                <th class="text-right" style="width: 20%;"><?php echo pdf_text('frontend.price', true); ?></th>
                <th class="text-right" style="width: 20%;"><?php echo pdf_text('frontend.total', true); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $invoice->order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <?php if(app()->getLocale() == 'ar'): ?>
                <td class="text-left"><?php echo e(number_format($item->total ?? (($item->unit_price ?? 0) * ($item->quantity ?? 1)), 2)); ?></td>
                <td class="text-left"><?php echo e(number_format($item->unit_price ?? 0, 2)); ?></td>
                <td><?php echo e($item->quantity ?? 1); ?></td>
                <td>
                    <div class="item-name"><?php echo e($item->product_name ?? $item->item_name ?? 'N/A'); ?></div>
                    <?php if($item->description): ?>
                    <div class="item-description"><?php echo e($item->description); ?></div>
                    <?php endif; ?>
                </td>
                <?php else: ?>
                <td>
                    <div class="item-name"><?php echo e($item->product_name ?? $item->item_name ?? 'N/A'); ?></div>
                    <?php if($item->description): ?>
                    <div class="item-description"><?php echo e($item->description); ?></div>
                    <?php endif; ?>
                </td>
                <td><?php echo e($item->quantity ?? 1); ?></td>
                <td class="text-right"><?php echo e(number_format($item->unit_price ?? 0, 2)); ?></td>
                <td class="text-right"><?php echo e(number_format($item->total ?? (($item->unit_price ?? 0) * ($item->quantity ?? 1)), 2)); ?></td>
                <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php endif; ?>

    <div class="summary-container">
        <table class="summary-table">
            <tr>
                <td class="summary-label"><?php echo pdf_text('frontend.subtotal'); ?></td>
                <td class="summary-value"><?php echo e(number_format($invoice->subtotal, 2)); ?> <?php echo e($invoice->currency ?? 'USD'); ?></td>
            </tr>
            <?php if($invoice->tax > 0): ?>
            <tr>
                <td class="summary-label"><?php echo pdf_text('frontend.tax'); ?></td>
                <td class="summary-value"><?php echo e(number_format($invoice->tax, 2)); ?> <?php echo e($invoice->currency ?? 'USD'); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($invoice->discount > 0): ?>
            <tr>
                <td class="summary-label"><?php echo pdf_text('frontend.discount'); ?></td>
                <td class="summary-value">-<?php echo e(number_format($invoice->discount, 2)); ?> <?php echo e($invoice->currency ?? 'USD'); ?></td>
            </tr>
            <?php endif; ?>
            <tr class="summary-total">
                <td class="summary-label"><?php echo pdf_text('frontend.total'); ?></td>
                <td class="summary-value"><?php echo e(number_format($invoice->total, 2)); ?> <?php echo e($invoice->currency ?? 'USD'); ?></td>
            </tr>
            <?php if($invoice->paid_amount > 0): ?>
            <tr class="summary-paid">
                <td class="summary-label"><?php echo pdf_text('frontend.paid_amount'); ?></td>
                <td class="summary-value"><?php echo e(number_format($invoice->paid_amount, 2)); ?> <?php echo e($invoice->currency ?? 'USD'); ?></td>
            </tr>
            <?php endif; ?>
            <?php if($invoice->balance > 0): ?>
            <tr class="summary-balance">
                <td class="summary-label"><?php echo pdf_text('frontend.balance_due'); ?></td>
                <td class="summary-value"><?php echo e(number_format($invoice->balance, 2)); ?> <?php echo e($invoice->currency ?? 'USD'); ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="clear"></div>

    <?php if($invoice->notes): ?>
    <div class="notes">
        <div class="notes-label"><?php echo pdf_text('frontend.notes', app()->getLocale() != 'ar'); ?></div>
        <div class="notes-text"><?php echo e($invoice->notes); ?></div>
    </div>
    <?php endif; ?>

    <?php
        $transactions = $invoice->getAllTransactions();
    ?>
    
    <?php if($transactions->count() > 0): ?>
    <div class="transactions-section">
        <div class="section-title"><?php echo pdf_text('frontend.transaction_history', app()->getLocale() != 'ar'); ?></div>
        <table class="items-table">
            <thead>
                <tr>
                    <?php if(app()->getLocale() == 'ar'): ?>
                    <th class="text-left"><?php echo pdf_text('frontend.amount'); ?></th>
                    <th><?php echo pdf_text('frontend.transaction_id'); ?></th>
                    <th><?php echo pdf_text('frontend.gateway'); ?></th>
                    <th><?php echo pdf_text('frontend.date'); ?></th>
                    <?php else: ?>
                    <th><?php echo pdf_text('frontend.date', true); ?></th>
                    <th><?php echo pdf_text('frontend.gateway', true); ?></th>
                    <th><?php echo pdf_text('frontend.transaction_id', true); ?></th>
                    <th class="text-right"><?php echo pdf_text('frontend.amount', true); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php if(app()->getLocale() == 'ar'): ?>
                    <td class="text-left"><?php echo e(number_format($transaction['amount'], 2)); ?> <?php echo e($transaction['currency']); ?></td>
                    <td><?php echo e($transaction['transaction_id']); ?></td>
                    <td><?php echo e($transaction['gateway']); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($transaction['date'])->format('M d, Y')); ?></td>
                    <?php else: ?>
                    <td><?php echo e(\Carbon\Carbon::parse($transaction['date'])->format('M d, Y')); ?></td>
                    <td><?php echo e($transaction['gateway']); ?></td>
                    <td><?php echo e($transaction['transaction_id']); ?></td>
                    <td class="text-right"><?php echo e(number_format($transaction['amount'], 2)); ?> <?php echo e($transaction['currency']); ?></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="signature-section clearfix">
        <div class="qr-container">
            <div class="qr-title"><?php echo pdf_text('frontend.qr_code'); ?></div>
            <div class="qr-code-box">
                <?php if($qrCode && $qrFormat === 'svg'): ?>
                    <img src="data:image/svg+xml;base64,<?php echo e($qrCode); ?>" alt="QR Code" style="width: 120px; height: 120px;">
                <?php else: ?>
                    <div style="width: 120px; height: 120px; border: 2px dashed #d1d5db; display: flex; align-items: center; justify-content: center; font-size: 8pt; color: #9ca3af; text-align: center; padding: 10px;">
                        <?php echo e(route('client.invoices.show', $invoice->id)); ?>

                    </div>
                <?php endif; ?>
            </div>
            <div class="qr-label"><?php echo pdf_text('frontend.scan_to_view'); ?></div>
        </div>
        <div class="signature-container">
            <div class="signature-hash">
                <strong><?php echo pdf_text('frontend.document_hash'); ?>:</strong><br>
                <?php echo e(strtoupper(substr(hash('sha256', $invoice->invoice_number . $invoice->invoice_date), 0, 32))); ?>

            </div>
        </div>
    </div>

    <div class="footer">
        <?php echo pdf_text('frontend.thank_you_business'); ?>

    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\resources\views/frontend/client/invoices/pdf.blade.php ENDPATH**/ ?>