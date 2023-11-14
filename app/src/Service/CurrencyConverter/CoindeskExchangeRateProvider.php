<?php

namespace App\Service\CurrencyConverter;

use App\Entity\Quote;
use Doctrine\ORM\EntityManagerInterface;

class CoindeskExchangeRateProvider implements ExchangeRateProviderInterface
{
    private EntityManagerInterface $entityManager;
    private $code;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->code = 'BTC';
    }
    public function getExchangeRate(string $sourceCurrency, string $targetCurrency): null|float
    {
        if($sourceCurrency===$targetCurrency){
            return 1.0;
        }

         $rate = match("BTC"){
            $sourceCurrency => $this->defaultExchange(
                targetCurrency: $targetCurrency,
                reverse:false
            ),
            $targetCurrency => $this->defaultExchange(
                targetCurrency: $sourceCurrency,
                reverse: true
            ),
            default => $this->customExchange(
                sourceCurrency: $sourceCurrency,
                targetCurrency: $targetCurrency
            )
        };

        return (float)number_format($rate, 7, '.', '');
    }

    private function defaultExchange(
        string $targetCurrency,
        bool $reverse
    ) : ?float{

        $quoteRepository = $this->entityManager->getRepository(Quote::class);

        // Пытаемся найти курс обмена для заданных валют
        $exchangeRate = $quoteRepository->findOneBy([
            'curCodeFrom' => $this->code,
            'curCodeTo' => $targetCurrency,
        ]);

        return !$reverse?$exchangeRate->getRate():(1/$exchangeRate->getRate());
    }

    private function customExchange(
        string $sourceCurrency,
        string $targetCurrency
    ) : ?float{

        $quoteRepository = $this->entityManager->getRepository(Quote::class);

        // Пытаемся найти курс обмена для заданных валют
        $exchangeRateFirst = $quoteRepository->findOneBy([
            'curCodeFrom' => $this->code,
            'curCodeTo' => $sourceCurrency,
        ]);

        $exchangeRateSecond = $quoteRepository->findOneBy([
            'curCodeFrom' => $this->code,
            'curCodeTo' => $targetCurrency,
        ]);

        return $exchangeRateFirst->getRate()/$exchangeRateSecond->getRate();
    }
}
