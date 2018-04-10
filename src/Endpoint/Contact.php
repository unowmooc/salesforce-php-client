<?php

namespace Salesforce\Endpoint;

/**
 * @package Salesforce\Endpoint
 */
class Contact extends AbstractEndpoint
{
    const ENDPOINT = 'Contact';

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
