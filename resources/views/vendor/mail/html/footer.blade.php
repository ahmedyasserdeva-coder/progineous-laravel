@php
    $isRtl = app()->getLocale() === 'ar';
    $direction = $isRtl ? 'rtl' : 'ltr';
@endphp
<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="direction: {{ $direction }};">
<tr>
<td class="content-cell" align="center">
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
</tr>
</table>
</td>
</tr>
