<?php

namespace App;

class CurrencyRatesProvider
{
    private const BASE_EXCHANGE_ENDPOINT = 'https://api.exchangeratesapi.io';

    public function getExchangeRate(string $currency)
    {
        $content = file_get_contents(self::BASE_EXCHANGE_ENDPOINT . '/latest');

        if ($content === null) {
            throw new \Exception("Can't get exchange rate");
        }

        $content = json_decode($content, true);

        return $content['rates'][$currency] ?? 0;
    }
}