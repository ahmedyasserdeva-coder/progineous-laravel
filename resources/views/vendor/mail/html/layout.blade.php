@php
    $mailLocale = session('mail_locale', app()->getLocale());
    $isRtl = $mailLocale === 'ar';
    $direction = $isRtl ? 'rtl' : 'ltr';
    $textAlign = $isRtl ? 'right' : 'left';
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{{ $direction }}" lang="{{ $mailLocale }}">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
/* Base RTL Support - without !important to allow inline override */
[dir="rtl"] {
    direction: rtl;
}

[dir="rtl"] .content-cell {
    text-align: right;
}

@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
padding: 10px !important;
}

.footer {
width: 100% !important;
}

.content-cell {
padding: 20px !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}

h1 {
font-size: 22px !important;
}

h2 {
font-size: 16px !important;
}

table {
width: 100% !important;
}

td {
display: block !important;
width: 100% !important;
text-align: left !important;
padding: 8px 0 !important;
}
}
</style>
{!! $head ?? '' !!}
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
{!! $header ?? '' !!}

<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<!-- Body content -->
<tr>
<td class="content-cell">
{!! Illuminate\Mail\Markdown::parse($slot) !!}

{!! $subcopy ?? '' !!}
</td>
</tr>
</table>
</td>
</tr>

{!! $footer ?? '' !!}
</table>
</td>
</tr>
</table>
</body>
</html>
