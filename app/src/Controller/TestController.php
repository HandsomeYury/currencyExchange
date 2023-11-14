<?php
namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TestController extends AbstractController
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/convert', name: 'test_convert')]
    public function convert(): Response
    {
        try {
            $response = $this->httpClient->request('GET', 'https://api.coindesk.com/v1/bpi/currentprice.json');

            return $this->render('/test/default.html.twig', [
                'json' => $response->getContent(),
            ]);
        } catch (HttpExceptionInterface $e) {
            // Обработка исключения при неудачном запросе
            $statusCode = $e->getResponse()->getStatusCode();
            $errorMessage = $e->getMessage();
            return $this->render('/test/default.html.twig', [
                'data' => $statusCode.': '.$errorMessage,
            ]);
        }
    }


    /**
     * @throws Exception
     */
    #[Route('/testCommand', name: 'test_debugCommand')]
    public function debugCommand(KernelInterface $kernel): Response
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'app:currency:convert',
            'amount' => 10,
            'sourceCurrency' => 'EUR',
            'targetCurrency' => 'USD',
        ]);

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $application->run($input, $output);

        // return the output, don't use if you used NullOutput()
        $content = $output->fetch();

        // return new Response(""), if you used NullOutput()
        return new Response($content);
    }
}
