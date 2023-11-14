<?php

namespace App\Command;

use App\Service\QuoteImporter\QuoteImportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QuoteImportCommand extends Command
{
    protected static $defaultName = 'app:quote:import';
    private QuoteImportService $quoteImportService;

    public function __construct(QuoteImportService $quoteImportService)
    {
        parent::__construct();
        $this->quoteImportService = $quoteImportService;
    }

    protected function configure()
    {
        $this->setDescription('Import quotes from different sources.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // get data from diff sources (ECB, Coindesk,...)
        $data = []; // Замените эту строку на фактический код получения данных

        // Запускаем импорт
        $this->quoteImportService->importQuotes();

        $output->writeln('Quotes imported successfully.');

        return Command::SUCCESS;
    }
}
