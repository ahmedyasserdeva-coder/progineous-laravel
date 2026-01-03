<?php
    $isRtl = app()->getLocale() === 'ar';
    $direction = $isRtl ? 'rtl' : 'ltr';
    $textAlign = $isRtl ? 'right' : 'left';
?>
<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<tr>
<td style="text-align: <?php echo new \Illuminate\Support\EncodedHtmlString($textAlign); ?>;">
<?php echo new \Illuminate\Support\EncodedHtmlString(Illuminate\Mail\Markdown::parse($slot)); ?>

</td>
</tr>
</table>
<?php /**PATH C:\laragon\www\resources\views/vendor/mail/html/subcopy.blade.php ENDPATH**/ ?>