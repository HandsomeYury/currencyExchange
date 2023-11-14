<?php
namespace App\Service\QuoteImporter;

use App\Entity\Quote;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class EcbQuoteImporter implements QuoteImporterInterface
{
    private string $url;
    private string $code;
    private EntityManagerInterface $entityManager;

    public function __construct(string $url, string $code, EntityManagerInterface $entityManager)
    {
        $this->url = $url;
        $this->code = $code;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function import(): void
    {
        try {
            $httpClient = HttpClient::create();
            $response = $httpClient->request('GET', $this->url);

            $xmlString = $response->getContent();

            $xml = simplexml_load_string($xmlString);

            $data = [];

            $data['time'] = (string)$xml->Cube->Cube['time'];

            foreach ($xml->Cube->Cube->Cube as $quoteData) {
                $quote = new Quote();
                $quote->setSource($this->code);
                $quote->setCurCodeFrom("EUR");
                $quote->setCurCodeTo($quoteData['currency']->__toString());
                $quote->setRate($quoteData['rate']->__toString());
                $quote->setDate(new \DateTime($data['time']));

                $this->entityManager->persist($quote);
            }

            $this->entityManager->flush();

        } catch (\Exception $e) {
            throw new Exception('Error fetching data from ECB: ' . $e->getMessage());
        }
    }
}