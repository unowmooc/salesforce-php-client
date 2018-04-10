<?php

namespace Salesforce\Endpoint;

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

        return $this->client->get($path);
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function find($id)
    {
        $path = sprintf('/%s/%s', self::ENDPOINT, $id);

        $path = '/Account/0010Y00000dR2hBQAS/Contacts';

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
