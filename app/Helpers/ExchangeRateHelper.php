<?php

namespace App\Helpers;

use InvalidArgumentException;

class ExchangeRateHelper
{
    const CURRENCIES = ["EUR", "GBP", "NGN", "USD", "VND", "JPY", "CNY", "INR", "AUD", "CAD", "SGD", "CHF", "MYR", "NZD", "THB", "HUF", "AED", "HKD", "MXN", "ZAR", "PHP", "SEK", "IDR", "SAR", "BRL", "TRY", "KES", "KRW", "EGP", "IQD", "NOK", "KWD", "RUB", "DKK", "PKR", "ILS", "PLN", "QAR", "XAU", "OMR", "COP", "CLP", "TWD", "ARS", "CZK", "VND", "MAD", "JOD", "BHD", "XOF", "LKR", "UAH", "NGN", "TND", "UGX", "RON", "BDT", "PEN", "GEL", "XAF", "FJD", "VEF", "VES", "BYN", "HRK", "UZS", "BGN", "DZD", "IRR", "DOP", "ISK", "XAG", "CRC", "SYP", "LYD", "JMD", "MUR", "GHS", "AOA", "UYU", "AFN", "LBP", "XPF", "TTD", "TZS", "ALL", "XCD", "GTQ", "NPR", "BOB", "ZWD", "BBD", "CUC", "LAK", "BND", "BWP", "HNL", "PYG", "ETB", "NAD", "PGK", "SDG", "MOP", "NIO", "BMD", "KZT", "PAB", "BAM", "GYD", "YER", "MGA", "KYD", "MZN", "RSD", "SCR", "AMD", "SBD", "AZN", "SLL", "TOP", "BZD", "MWK", "GMD", "BIF", "SOS", "HTG", "GNF", "MVR", "MNT", "CDF", "STN", "TJS", "KPW"];

    public static function getRatesForCurrency(string $currency): array
    {
        $currencies = self::CURRENCIES;

        $index = array_search($currency, $currencies);

        if ($index === false) {
            throw new InvalidArgumentException("Unsupported currency provided");
        }

        array_splice($currencies, $index, 1);

        $rates = [];

        foreach ($currencies as $currency) {
            $rates[$currency] = round(lcg_value(), 2);
        }

        return $rates;
    }

    public static function getAllRates(): array
    {
        $rates = [];
        foreach (self::CURRENCIES as $currency) {
            $rates[$currency] = self::getRatesForCurrency($currency);
        }
        return $rates;
    }

    public static function getSupportedCurrencies(): array
    {
        return self::CURRENCIES;
    }
}
