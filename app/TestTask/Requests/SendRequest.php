<?php

namespace App\TestTask\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Log\LoggerInterface;

/**
 * Шлюз
 */
final class SendRequest
{
    protected Client $client;
    protected string $baseUrl;
    private LoggerInterface $logger;
    private string $accessToken;

    public function __construct(LoggerInterface $logger)
    {
        $this->client = new Client();
        $this->baseUrl = env('BASE_URL');
        $this->accessToken = env('ACCESS_TOKEN');
        $this->logger = $logger;
    }

    public function get(string $method, ?array $getParams = []): mixed
    {
        try {
            $response = $this->client->get($this->baseUrl . '/' . $method, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ],
                'query' => $getParams,
            ]);

            if ($response->getStatusCode() === 200) {
                $this->logger->info('DONE', $this->context($method, $getParams));

                return json_decode($response->getBody(), true);
            }
        } catch (GuzzleException $e) {
            $this->logger->error('ERROR: '.$e->getMessage(), $this->context($method, $getParams));
        }

        return false;
    }

    public function post(string $method, ?array $getParams = [], ?array $postParams = []): mixed
    {
        try {
            $response = $this->client->post($this->baseUrl . '/' . $method, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ],
                'form_params'  => $postParams,
                'query'        => $getParams,
            ]);

            if ($response->getStatusCode() === 200) {
                $this->logger->info('DONE', $this->context($method, array_merge($getParams, $postParams)));
                return json_decode($response->getBody(), true);
            }
        } catch (GuzzleException $e) {
            $this->logger->error('ERROR: '.$e->getMessage(), $this->context($method, array_merge($getParams, $postParams)));
        }

        return false;
    }

    /**
     * Возвращает контекст для каждого лог-сообщения
     */
    #[ArrayShape(['method' => "", 'params' => "string"])] protected function context($method, $params): array
    {
        return [
            'method' => $method,
            'params' => serialize($params),
        ];
    }
}
