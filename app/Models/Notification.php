<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'client_id',
        'type',
        'title',
        'message',
        'data',
        'read',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read' => 'boolean',
        'read_at' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function markAsRead()
    {
        $this->update([
            'read' => true,
            'read_at' => now()
        ]);
    }

    public function getLocalizedTitle()
    {
        $title = json_decode($this->title, true);
        if (is_array($title)) {
            $locale = app()->getLocale();
            return $title[$locale] ?? $title['en'] ?? $this->title;
        }
        return $this->title;
    }

    public function getLocalizedMessage()
    {
        $message = json_decode($this->message, true);
        if (is_array($message)) {
            $locale = app()->getLocale();
            return $message[$locale] ?? $message['en'] ?? $this->message;
        }
        return $this->message;
    }

    public static function createTransferNotification($clientId, $type, $amount, $username, $reference)
    {
        if ($type === 'transfer_sent') {
            $titleAr = 'تحويل أموال';
            $titleEn = 'Money Transfer';
            $messageAr = "تم تحويل $$amount إلى @$username بنجاح";
            $messageEn = "Successfully transferred $$amount to @$username";
        } else { // transfer_received
            $titleAr = 'استلام أموال';
            $titleEn = 'Money Received';
            $messageAr = "تم استلام $$amount من @$username";
            $messageEn = "Received $$amount from @$username";
        }

        return self::create([
            'client_id' => $clientId,
            'type' => $type,
            'title' => json_encode(['ar' => $titleAr, 'en' => $titleEn]),
            'message' => json_encode(['ar' => $messageAr, 'en' => $messageEn]),
            'data' => [
                'amount' => $amount,
                'username' => $username,
                'reference' => $reference,
                'type' => $type
            ]
        ]);
    }

    public static function createDepositNotification($clientId, $status, $amount, $reference, $paymentMethod = null)
    {
        if ($status === 'success') {
            $titleAr = 'إيداع ناجح';
            $titleEn = 'Deposit Successful';
            $messageAr = "تم إضافة $$amount إلى محفظتك بنجاح";
            $messageEn = "Successfully added $$amount to your wallet";
            $type = 'deposit_success';
        } elseif ($status === 'failed') {
            $titleAr = 'فشل الإيداع';
            $titleEn = 'Deposit Failed';
            $messageAr = "فشلت عملية إضافة $$amount إلى محفظتك";
            $messageEn = "Failed to add $$amount to your wallet";
            $type = 'deposit_failed';
        } elseif ($status === 'cancelled') {
            $titleAr = 'إلغاء الإيداع';
            $titleEn = 'Deposit Cancelled';
            $messageAr = "تم إلغاء عملية إضافة $$amount إلى محفظتك";
            $messageEn = "Cancelled adding $$amount to your wallet";
            $type = 'deposit_cancelled';
        } else { // pending
            $titleAr = 'إيداع قيد المعالجة';
            $titleEn = 'Deposit Pending';
            $messageAr = "جاري معالجة إضافة $$amount إلى محفظتك";
            $messageEn = "Processing $$amount deposit to your wallet";
            $type = 'deposit_pending';
        }

        return self::create([
            'client_id' => $clientId,
            'type' => $type,
            'title' => json_encode(['ar' => $titleAr, 'en' => $titleEn]),
            'message' => json_encode(['ar' => $messageAr, 'en' => $messageEn]),
            'data' => [
                'amount' => $amount,
                'reference' => $reference,
                'payment_method' => $paymentMethod,
                'status' => $status
            ]
        ]);
    }
}

