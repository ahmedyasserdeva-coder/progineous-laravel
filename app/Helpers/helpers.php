<?php

use App\Helpers\CurrencyHelper;
use App\Helpers\ArabicHelper;

if (!function_exists('currency')) {
    /**
     * Format price with current currency
     */
    function currency($price, $currency = null)
    {
        return CurrencyHelper::format($price, $currency);
    }
}

if (!function_exists('price_convert')) {
    /**
     * Convert price to current currency
     */
    function price_convert($price, $currency = null)
    {
        return CurrencyHelper::convert($price, $currency);
    }
}

if (!function_exists('current_currency')) {
    /**
     * Get current currency
     */
    function current_currency()
    {
        return CurrencyHelper::getCurrentCurrency();
    }
}

if (!function_exists('fix_arabic')) {
    function fix_arabic($text)
    {
        return \App\Helpers\ArabicHelper::fixArabicText($text);
    }
}

if (!function_exists('trans_arabic')) {
    function trans_arabic($key)
    {
        $translation = __($key);
        if (app()->getLocale() == 'ar') {
            return \App\Helpers\ArabicHelper::fixArabicText($translation);
        }
        return $translation;
    }
}
