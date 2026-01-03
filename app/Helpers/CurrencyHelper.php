<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class CurrencyHelper
{
    // Exchange rates (you should update these from an API)
    // Base currency: USD
    private static $exchangeRates = [
        'USD' => 1,       // US Dollar (base)
        'EGP' => 30.90,   // Egyptian Pound
        'SAR' => 3.75,    // Saudi Riyal
        'AED' => 3.67,    // UAE Dirham
        'KWD' => 0.31,    // Kuwaiti Dinar
        'QAR' => 3.64,    // Qatari Riyal
        'BHD' => 0.38,    // Bahraini Dinar
    ];

    private static $currencySymbols = [
        'USD' => '$',
        'EGP' => 'ج.م',
        'SAR' => 'ر.س',
        'AED' => 'د.إ',
        'KWD' => 'د.ك',
        'QAR' => 'ر.ق',
        'BHD' => 'د.ب',
    ];

    private static $currencyNames = [
        'EGP' => 'جنيه مصري',
        'USD' => 'دولار أمريكي',
        'SAR' => 'ريال سعودي',
        'AED' => 'درهم إماراتي',
        'KWD' => 'دينار كويتي',
        'QAR' => 'ريال قطري',
        'BHD' => 'دينار بحريني',
    ];

    /**
     * Get current currency
     */
    public static function getCurrentCurrency()
    {
        return Session::get('currency', config('app.default_currency', 'USD'));
    }

    /**
     * Convert price to current currency
     */
    public static function convert($priceInUSD, $targetCurrency = null)
    {
        if ($targetCurrency === null) {
            $targetCurrency = self::getCurrentCurrency();
        }

        if (!isset(self::$exchangeRates[$targetCurrency])) {
            return $priceInUSD;
        }

        return $priceInUSD * self::$exchangeRates[$targetCurrency];
    }

    /**
     * Format price with currency symbol
     */
    public static function format($price, $currency = null)
    {
        if ($currency === null) {
            $currency = self::getCurrentCurrency();
        }

        $convertedPrice = self::convert($price, $currency);
        $symbol = self::$currencySymbols[$currency] ?? '$';

        // Format based on currency
        // EGP doesn't use decimals commonly
        if ($currency === 'EGP') {
            return number_format($convertedPrice, 0) . ' ' . $symbol;
        }
        // Gulf currencies (KWD, BHD) use 3 decimals for fils
        elseif (in_array($currency, ['KWD', 'BHD'])) {
            return number_format($convertedPrice, 3) . ' ' . $symbol;
        }
        // Other Middle East currencies show 2 decimals
        elseif (in_array($currency, ['SAR', 'AED', 'QAR'])) {
            return number_format($convertedPrice, 2) . ' ' . $symbol;
        }
        // USD and others
        else {
            return $symbol . number_format($convertedPrice, 2);
        }
    }

    /**
     * Get currency symbol
     */
    public static function getSymbol($currency = null)
    {
        if ($currency === null) {
            $currency = self::getCurrentCurrency();
        }

        return self::$currencySymbols[$currency] ?? '$';
    }

    /**
     * Get all available currencies
     */
    public static function getAvailableCurrencies()
    {
        return array_keys(self::$exchangeRates);
    }

    /**
     * Get currency name in Arabic
     */
    public static function getCurrencyName($currency = null)
    {
        if ($currency === null) {
            $currency = self::getCurrentCurrency();
        }

        return self::$currencyNames[$currency] ?? 'دولار أمريكي';
    }

    /**
     * Get all currency names
     */
    public static function getAllCurrencyNames()
    {
        return self::$currencyNames;
    }

    /**
     * Check if currency is supported by Fawaterak
     */
    public static function isSupportedCurrency($currency)
    {
        $supportedCurrencies = ['USD', 'EGP', 'SAR', 'AED', 'KWD', 'QAR', 'BHD'];
        return in_array(strtoupper($currency), $supportedCurrencies);
    }

    /**
     * Get Fawaterak supported currencies
     */
    public static function getFawaterakCurrencies()
    {
        return [
            'USD' => 'دولار أمريكي',
            'EGP' => 'جنيه مصري',
            'SAR' => 'ريال سعودي',
            'AED' => 'درهم إماراتي',
            'KWD' => 'دينار كويتي',
            'QAR' => 'ريال قطري',
            'BHD' => 'دينار بحريني',
        ];
    }

    /**
     * Format currency with symbol and name
     */
    public static function formatWithName($amount, $currency = null)
    {
        if ($currency === null) {
            $currency = self::getCurrentCurrency();
        }

        $formatted = self::format($amount, $currency);
        $name = self::getCurrencyName($currency);
        
        return "{$formatted} ({$name})";
    }

    /**
     * Update exchange rate (call this from a scheduled job)
     */
    public static function updateExchangeRate($currency, $rate)
    {
        self::$exchangeRates[$currency] = $rate;
    }
}