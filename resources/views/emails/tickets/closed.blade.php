@component('mail::message')
@php
    $isArabic = $locale === 'ar';
@endphp

# {{ $isArabic ? 'مرحباً ' . $client->first_name : 'Hello ' . $client->first_name }}

{{ $isArabic ? 'تم إغلاق تذكرة الدعم الخاصة بك.' : 'Your support ticket has been closed.' }}

---

**{{ $isArabic ? 'رقم التذكرة:' : 'Ticket Number:' }}** {{ $ticket->ticket_number }}

**{{ $isArabic ? 'الموضوع:' : 'Subject:' }}** {{ $ticket->subject }}

**{{ $isArabic ? 'تاريخ الإغلاق:' : 'Closed On:' }}** {{ $ticket->closed_at->format('Y-m-d H:i') }}

---

{{ $isArabic ? 'إذا كنت بحاجة إلى مزيد من المساعدة، يمكنك إعادة فتح هذه التذكرة أو إنشاء تذكرة جديدة.' : 'If you need further assistance, you can reopen this ticket or create a new one.' }}

@component('mail::button', ['url' => route('client.tickets.show', $ticket)])
{{ $isArabic ? 'عرض التذكرة' : 'View Ticket' }}
@endcomponent

{{ $isArabic ? 'شكراً لك،' : 'Thanks,' }}<br>
{{ config('app.name') }}

---
<small>{{ $isArabic ? 'نأمل أن نكون قد قدمنا لك الخدمة المطلوبة. إذا كان لديك أي ملاحظات، لا تتردد في التواصل معنا.' : 'We hope we have provided you with the required service. If you have any feedback, please don\'t hesitate to contact us.' }}</small>
@endcomponent
