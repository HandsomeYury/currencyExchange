<?php

namespace App\Service\QuoteImporter;

use App\Entity\Quote;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CoindeskQuoteImporter implements QuoteImporterInterface
{
    private string $url;
    private string $code;
    private EntityManagerInterface $entityManager;

    public function __construct(string $url,string $code,EntityManagerInterface $entityManager)
    {
        $this->url = $url;
        $this->code = $code;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws Exception
     */
    public function import(): void
    {
        // TODO: Implement import() method.
        try {
            $httpClient = HttpClient::create();
            $response = $httpClient->request('GET', $this->url);

            $content = $response->getContent();
            $data = json_decode($content, true);

            if ($data === null) {
                throw new Exception('Failed to decode JSON.');
            }

            // Проверяем, что есть данные и ключ "bpi" существует
            if (isset($data['bpi']) && is_array($data['bpi'])) {

                foreach ($data['bpi'] as $currencyCode => $quoteData) {
                    $quote = new Quote();
                    $quote->setSource($this->code);
                    $quote->setCurCodeFrom("BTC");
                    $quote->setCurCodeTo((string)$currencyCode);
                    $quote->setRate($quoteData['rate_float']);
                    $quote->setDate(new \DateTime($data['time']['updatedISO']));

                    $this->entityManager->persist($quote);
                }

                $this->entityManager->flush();

            } else {
                echo "Ошибка: Неверный формат данных JSON.";
            }

        } catch (TransportException|TransportExceptionInterface|RedirectionExceptionInterface|ClientExceptionInterface|ServerExceptionInterface $e) {
            throw new Exception('Error fetching data from Coindesk: ' . $e->getMessage());
        }

    }
}
