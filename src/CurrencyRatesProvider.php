<?php

namespace App;

class CurrencyRatesProvider
{
    public function getExchangeRate(string $currency)
    {
        $response = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true);

        return $response['rates'][$currency] ?? 0;
    }
}