@component('mail::message')
@php
    $isArabic = $locale === 'ar';
@endphp

@if($recipientType === 'client')
# {{ $isArabic ? 'مرحباً ' . $client->first_name : 'Hello ' . $client->first_name }}

{{ $isArabic ? 'تم إنشاء تذكرة الدعم الخاصة بك بنجاح.' : 'Your support ticket has been created successfully.' }}
@else
# {{ $isArabic ? 'تذكرة دعم جديدة' : 'New Support Ticket' }}

{{ $isArabic ? 'تم إنشاء تذكرة دعم جديدة بواسطة العميل:' : 'A new support ticket has been created by client:' }} **{{ $client->first_name }} {{ $client->last_name }}**
@endif

---

**{{ $isArabic ? 'رقم التذكرة:' : 'Ticket Number:' }}** {{ $ticket->ticket_number }}

**{{ $isArabic ? 'الموضوع:' : 'Subject:' }}** {{ $ticket->subject }}

**{{ $isArabic ? 'القسم:' : 'Department:' }}** {{ $ticket->department->name }}

**{{ $isArabic ? 'الأولوية:' : 'Priority:' }}** {{ $ticket->priority_label }}

---

**{{ $isArabic ? 'الرسالة:' : 'Message:' }}**

{{ $ticket->message }}

---

@component('mail::button', ['url' => $recipientType === 'client' ? route('client.tickets.show', $ticket) : route('admin.tickets.show', $ticket)])
{{ $isArabic ? 'عرض التذكرة' : 'View Ticket' }}
@endcomponent

{{ $isArabic ? 'شكراً لك،' : 'Thanks,' }}<br>
{{ config('app.name') }}

@if($recipientType === 'client')
---
<small>{{ $isArabic ? 'إذا كنت بحاجة إلى مساعدة إضافية، يمكنك الرد على هذه التذكرة من خلال لوحة التحكم الخاصة بك.' : 'If you need additional help, you can reply to this ticket through your dashboard.' }}</small>
@endif
@endcomponent
