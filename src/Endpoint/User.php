<?php

namespace Salesforce\Endpoint;

/**
 * @package Salesforce\Endpoint
 */
class User extends AbstractEndpoint
{
    const ENDPOINT = 'sobjects/User';

    /**
     * @param string $id
     *
     * @return array
     */
    public function find($id)
    {
        $path = sprintf('/%s/%s', self::ENDPOINT, $id);

        return $this->client->get($path);
    }
}
