<?php

namespace Salesforce\Endpoint;

use Salesforce\Client;

/**
 * @package Salesforce\Endpoint
 */
abstract class AbstractEndpoint
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
