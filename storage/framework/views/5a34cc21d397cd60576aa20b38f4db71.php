<?php
    $isRtl = app()->getLocale() === 'ar';
    $direction = $isRtl ? 'rtl' : 'ltr';
?>
<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="direction: <?php echo new \Illuminate\Support\EncodedHtmlString($direction); ?>;">
<tr>
<td class="content-cell" align="center">
<?php echo new \Illuminate\Support\EncodedHtmlString(Illuminate\Mail\Markdown::parse($slot)); ?>

</td>
</tr>
</table>
</td>
</tr>
<?php /**PATH C:\laragon\www\resources\views/vendor/mail/html/footer.blade.php ENDPATH**/ ?>