<?php

namespace Salesforce;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\Authentication\Bearer;
use Http\Message\MessageFactory;
use Salesforce\Endpoint\Account;
use Salesforce\Endpoint\Contact;
use Salesforce\Endpoint\Opportunity;
use Salesforce\Endpoint\User;

/**
 * @package Salesforce
 */
class Salesforce
{
    const LOGIN_URL = 'https://login.salesforce.com/services/oauth2/token';
    const BASE_URI = '/services/data/v42.0/sobjects';

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $salesforceInstance;

    /**
     * @param string $clientId
     * @param string $secret
     * @param string $username
     * @param string $password
     */
    public function __construct(string $clientId, string $secret, string $username, string $password)
    {
        //Login
        $data = $this->login($clientId, $secret, $username, $password);

        //create authenticated client
        $defaultHeaders = new HeaderDefaultsPlugin([
            'Authorization' => sprintf('Bearer %s', $data['access_token'])
        ]);

        $defaultUri = new BaseUriPlugin(UriFactoryDiscovery::find()->createUri($data['instance_url'] . self::BASE_URI), [
            // Always replace the host, even if this one is provided on the sent request. Available for AddHostPlugin.
            'replace' => true,
        ]);

        $this->client = new Client(
            new PluginClient(
                HttpClientDiscovery::find(),
                [$defaultUri, $defaultHeaders]
            ),
            MessageFactoryDiscovery::find()
        );
    }

    /**
     * @param string $clientId
     * @param string $secret
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function login(string $clientId, string $secret, string $username, string $password)
    {
        $parameters = [
            'grant_type'    => 'password',
            'client_id'     => $clientId,
            'client_secret' => $secret,
            'username'      => $username,
            'password'      => $password,
        ];

        $client = new Client(
            HttpClientDiscovery::find(),
            MessageFactoryDiscovery::find()
        );

        return $client->post(self::LOGIN_URL, http_build_query($parameters));
    }

    /**
     * @return Account
     */
    public function account()
    {
        return new Account($this->client);
    }

    /**
     * @return Opportunity
     */
    public function opportunity()
    {
        return new Opportunity($this->client);
    }

    /**
     * @return User
     */
    public function user()
    {
        return new User($this->client);
    }

    /**
     * @return Contact
     */
    public function contact()
    {
        return new Contact($this->client);
    }
}
