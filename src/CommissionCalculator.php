<?php

namespace App;

class CommissionCalculator
{
    private $row;

    private BinProvider $binProvider;
    private CurrencyRatesProvider $ratesProvider;

    private const EU_COMMISSION_RATE = 0.01;
    private const NON_EU_COMMISSION_RATE = 0.02;

    private const EUR_CURRENCY = 'EUR';

    public function __construct($row, BinProvider $binProvider, CurrencyRatesProvider $ratesProvider)
    {
        $this->row = $row;

        $this->binProvider = $binProvider;
        $this->ratesProvider = $ratesProvider;
    }

    public function calculateCommission()
    {
        if (empty($this->row)) {
            return null;
        }

        list($bin, $amount, $currency) = $this->extractData();

        $binResults = $this->binProvider->lookupBin($bin);

        if (!$binResults) {
            throw new \Exception("Can't get data");
        }

        $binData = json_decode($binResults);
        $isEu = $this->isEu($binData->country->alpha2);

        $rate = $this->ratesProvider->getExchangeRate($currency);

        if ($currency == self::EUR_CURRENCY || $rate === 0) {
            $amountFixed = $amount;
        } else {
            $amountFixed = $amount / $rate;
        }

        $commission = $amountFixed * ($isEu ? self::EU_COMMISSION_RATE : self::NON_EU_COMMISSION_RATE);

        return $this->roundCommission($commission);
    }

    public function extractData(): array
    {
        $params = json_decode($this->row, true);

        return [$params['bin'], $params['amount'], $params['currency']];
    }

    public function isEu(string $alpha2Code): bool
    {
        $euCountries = [
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR',
            'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK',
        ];

        return in_array($alpha2Code, $euCountries);
    }

    public function roundCommission($commission)
    {
        return ceil($commission * 100) / 100;
    }
}