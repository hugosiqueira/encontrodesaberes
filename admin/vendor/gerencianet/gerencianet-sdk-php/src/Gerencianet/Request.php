<?php

namespace Gerencianet;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Exception\AuthorizationException;

class Request
{
    private $client;
    private $baseUri;
    private $auth;
    private $request;
    private $config;

    public function __construct(array $options = null)
    {
        $this->config = Config::options($options);
        $composerData = json_decode(file_get_contents(__DIR__.'/../../composer.json'), true);
        $partner_token = isset($options['partner_token'])? $options['partner_token'] : "";
        $this->client = new Client([
        'debug' => $this->config['debug'],
        'base_url' => $this->config['baseUri'],
        'headers' => [
          'Content-Type' => 'application/json',
          'api-sdk' => 'php-' . $composerData['version'],
          'partner-token' => $partner_token
          ],
      ]);
    }

    public function send($method, $route, $requestOptions)
    {

        try {
            $this->request = $this->client->createRequest($method, $route, $requestOptions);
            $response = $this->client->send($this->request);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            throw new AuthorizationException($e->getResponse()->getStatusCode(),
                       $e->getResponse()->getReasonPhrase(),
                       $e->getResponse()->getBody());
        } catch (ServerException $se) {
            throw new GerencianetException($se->getResponse()->getBody());
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
