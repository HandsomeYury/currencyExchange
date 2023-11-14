<?php

namespace App\Service\CurrencyConverter;

class CurrencyConverterService
{
    private iterable $rateProviders;

    public function __construct(iterable $rateProviders)
    {
        $this->rateProviders = $rateProviders;
    }

    /**
     * @param float $amount
     * @param string $sourceCurrency
     * @param string $targetCurrency
     * @return float
     */
    public function convertCurrency(float $amount, string $sourceCurrency, string $targetCurrency): float
    {
        foreach ($this->rateProviders as $rateProvider) {
            $exchangeRate = $rateProvider->getExchangeRate($sourceCurrency, $targetCurrency);

            if ($exchangeRate !== null) {
                return $amount * $exchangeRate;
            }
        }

        throw new \RuntimeException('Exchange rate not available for the specified currencies.');
    }
}
