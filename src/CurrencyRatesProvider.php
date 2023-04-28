<?php

namespace App;

class CurrencyRatesProvider
{
    public function getExchangeRate(string $currency)
    {
        $content = file_get_contents('https://api.exchangeratesapi.io/latest');

        if ($content === null) {
            throw new \Exception("Can't get exchange rate");
        }

        $content = json_decode($content, true);

        return $content['rates'][$currency] ?? 0;
    }
}