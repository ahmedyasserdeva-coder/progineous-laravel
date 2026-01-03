@component('mail::message')
@php
    $isArabic = $locale === 'ar';
    $isFromClient = $reply->isFromClient();
@endphp

@if($recipientType === 'client')
# {{ $isArabic ? 'مرحباً ' . $ticket->client->first_name : 'Hello ' . $ticket->client->first_name }}

{{ $isArabic ? 'تم الرد على تذكرة الدعم الخاصة بك من قبل فريق الدعم الفني.' : 'Your support ticket has been replied to by our support team.' }}
@else
# {{ $isArabic ? 'رد جديد على التذكرة' : 'New Ticket Reply' }}

{{ $isArabic ? 'تم إضافة رد جديد من قبل العميل:' : 'A new reply has been added by client:' }} **{{ $ticket->client->first_name }} {{ $ticket->client->last_name }}**
@endif

---

**{{ $isArabic ? 'رقم التذكرة:' : 'Ticket Number:' }}** {{ $ticket->ticket_number }}

**{{ $isArabic ? 'الموضوع:' : 'Subject:' }}** {{ $ticket->subject }}

**{{ $isArabic ? 'الحالة:' : 'Status:' }}** {{ $ticket->status_label }}

---

**{{ $isArabic ? 'الرد الجديد:' : 'New Reply:' }}**

@if($isFromClient)
<small>{{ $isArabic ? 'من العميل' : 'From Client' }} - {{ $reply->created_at->format('Y-m-d H:i') }}</small>
@else
<small>{{ $isArabic ? 'من الدعم الفني' : 'From Support' }} - {{ $reply->created_at->format('Y-m-d H:i') }}</small>
@endif

{{ $reply->message }}

---

@component('mail::button', ['url' => $recipientType === 'client' ? route('client.tickets.show', $ticket) : route('admin.tickets.show', $ticket)])
{{ $isArabic ? 'عرض التذكرة' : 'View Ticket' }}
@endcomponent

{{ $isArabic ? 'شكراً لك،' : 'Thanks,' }}<br>
{{ config('app.name') }}
@endcomponent
