<?php

namespace Salesforce;

use Http\Client\Exception\HttpException;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @package Salesforce
 */
class Client
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @param HttpClient     $httpClient
     * @param MessageFactory $messageFactory
     * @param array          $headers
     */
    public function __construct(HttpClient $httpClient, MessageFactory $messageFactory, $headers = [])
    {
        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
        $this->headers = $headers;
    }

    /**
     * @param string $path
     * @param array  $headers
     *
     * @return array
     */
    public function get(string $path, array $headers = [])
    {
        $headers = array_merge(
            $this->headers,
            $headers
        );

        return $this->sendRequest('GET', $path, $headers);
    }

    /**
     * @param string $path
     * @param string $body
     * @param array  $headers
     *
     * @return array
     */
    public function post(string $path, $body, array $headers = [])
    {
        $headers = array_merge(
            $this->headers,
            $headers,
            ['content-type' => 'application/x-www-form-urlencoded']
        );

        return $this->sendRequest('POST', $path, $headers, $body);
    }

    /**
     * @param string                               $method
     * @param string|UriInterface                  $path
     * @param array                                $headers
     * @param resource|string|StreamInterface|null $body
     *
     * @return array
     * @throws \Exception
     */
    protected function sendRequest($method, $path, array $headers = [], $body = null)
    {
        try {
            $response = $this->httpClient->sendRequest($this->messageFactory->createRequest($method, $path, $headers, $body));
        } catch (HttpException $exception) {
            $response = $exception->getResponse();
        }

        $data = json_decode($response->getBody(), true);

        if (isset($data['error'])) {
            throw new \Exception(sprintf('[%s] %s', $data['error'], $data['error_description']));
        }

        return $data;
    }

    protected function beautifyColumns($columns)
    {
        return array_reduce($columns, function ($sum, $item) {
            $sum[$item['fieldNameOrPath']] = $item['value'];

            return $sum;
        }, []);
    }
}
