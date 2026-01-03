<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// جدولة تنظيف Activity Log تلقائياً كل يوم في منتصف الليل
Schedule::command('activitylog:cleanup')->daily();

// جدولة إلغاء المعاملات المعلقة القديمة (أكثر من 1 ساعة)
// يتم التشغيل كل 10 دقائق للتأكد من تنظيف المعاملات المنتهية بسرعة
Schedule::command('wallet:cancel-expired --hours=1')->everyTenMinutes();

// ============================================
// Billing & Invoice Automation
// ============================================

// إنشاء فواتير التجديد - يومياً في الساعة 8 صباحاً
// ينشئ فواتير للخدمات المستحقة خلال 14 يوم
Schedule::command('invoices:generate-renewals --days=14')
    ->dailyAt('08:00')
    ->withoutOverlapping()
    ->runInBackground();

// إرسال تذكيرات الفواتير - يومياً في الساعة 10 صباحاً
// يرسل تذكيرات قبل 3 أيام من الاستحقاق وبعد 1، 3، 7 أيام من التأخير
Schedule::command('invoices:send-reminders --days-before=3 --days-after=1,3,7')
    ->dailyAt('10:00')
    ->withoutOverlapping()
    ->runInBackground();

// تعليق الخدمات المتأخرة - يومياً في الساعة 6 صباحاً
// يعلق الخدمات المتأخرة 7 أيام ويلغي المتأخرة 30 يوم
Schedule::command('services:suspend-overdue --days=7 --terminate-days=30')
    ->dailyAt('06:00')
    ->withoutOverlapping()
    ->runInBackground();
