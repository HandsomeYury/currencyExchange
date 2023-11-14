<?php
namespace App\Service\QuoteImporter;

interface QuoteImporterInterface
{
    public function import(): void;
}