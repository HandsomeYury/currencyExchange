<?php
namespace App\Service\CurrencyConverter;

interface ExchangeRateProviderInterface
{
    public function getExchangeRate(string $sourceCurrency, string $targetCurrency): ?float;
}
