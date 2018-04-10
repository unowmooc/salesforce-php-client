<?php

namespace Salesforce\Endpoint;

/**
 * @package Salesforce\Endpoint
 */
class Opportunity extends AbstractEndpoint
{
    const ENDPOINT = 'Opportunity';

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

        return $this->client->get($path);
    }
}
