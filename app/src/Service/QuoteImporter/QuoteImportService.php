<?php
namespace App\Service\QuoteImporter;

class QuoteImportService
{
    private iterable $importers;

    public function __construct(iterable $importers)
    {
        $this->importers = $importers;
    }

    public function importQuotes(): void
    {
        foreach ($this->importers as $importer) {
            $importer->import();
        }
    }
}
