<?php
namespace App\Command;

use App\Service\CurrencyConverter\CurrencyConverterService;
use Symfony\Component\Console\{Command\Command,Input\InputArgument,Input\InputInterface,Output\OutputInterface};

class CurrencyConvertCommand extends Command
{
    protected static $defaultName = 'app:currency:convert';
    private CurrencyConverterService $currencyConverterService;

    public function __construct(CurrencyConverterService $currencyConverterService)
    {
        parent::__construct();
        $this->currencyConverterService = $currencyConverterService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Coindesk Currency converter')
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount to convert')
            ->addArgument('sourceCurrency', InputArgument::REQUIRED, 'Source currency code')
            ->addArgument('targetCurrency', InputArgument::REQUIRED, 'Target currency code');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $amount = (float)$input->getArgument('amount');
        $sourceCurrency = strtoupper($input->getArgument('sourceCurrency'));
        $targetCurrency = strtoupper($input->getArgument('targetCurrency'));

        $result = $this->currencyConverterService->convertCurrency($amount, $sourceCurrency, $targetCurrency);

        $output->writeln(sprintf('%s %s = %s %s', $amount, $sourceCurrency, $result, $targetCurrency));

        return Command::SUCCESS;
    }
}
