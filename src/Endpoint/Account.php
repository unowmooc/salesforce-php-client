<?php

namespace Salesforce\Endpoint;

use Salesforce\Formatter;

/**
 * @package Salesforce\Endpoint
 */
class Account extends AbstractEndpoint
{
    const ENDPOINT = 'Account';

    /**
     * @param string $listViewId
     * @param array  $parameters
     *
     * @return array
     */
    public function findAll(string $listViewId, $parameters = [])
    {
        $path = sprintf('/%s/listviews/%s/results', self::ENDPOINT, $listViewId);

        if (!empty($parameters)) {
            $path .= '/?'.http_build_query($parameters);
        }

        return Formatter::formatRecords($this->client->get($path));
    }

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

    /**
     * @param string $id
     *
     * @return array
     */
    public function findContacts($id)
    {
        $path = sprintf('/%s/%s/Contacts', self::ENDPOINT, $id);

        return $this->client->get($path);
    }
}
