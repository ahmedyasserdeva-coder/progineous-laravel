@php
    $isRtl = app()->getLocale() === 'ar';
    $direction = $isRtl ? 'rtl' : 'ltr';
    $textAlign = $isRtl ? 'right' : 'left';
@endphp
<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="direction: {{ $direction }};">
<tr>
<td style="text-align: {{ $textAlign }};">
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
</tr>
</table>
