<?php

namespace Codemax;

use GuzzleHttp\Client;

class Stripe
{
    use StripeEndpoints;

    private $apiKey;
    protected $connection_timeout = 2;
    protected $timeout = 10;
    private $headers;

    protected $host = 'https://api.stripe.com/';

    public function __construct($secretKey)
    {
        if (!empty($secretKey) && !is_null($secretKey)) {
            $this->apiKey = $secretKey;
        }
    }

    public function __call($function, $arguments)
    {
        if (count($arguments) > 0)
            $arguments = $arguments[0];
        return $this->runQuery($function, $arguments);
    }

    public function setHeader($name, $value = '')
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = (int) $timeout;
        return $this;
    }

    public function setConnectionTimeout($connection_timeout)
    {
        $this->connection_timeout = (int) $connection_timeout;
        return $this;
    }

    private function getHost()
    {
        return $this->host;
    }

    /**
     * get timeout.
     *
     * @return integer timeout of the Guzzle request
     *
     * @since v1.0.0
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * get connection timeout.
     *
     * @return integer connection timeout of the Guzzle request
     *
     * @since v1.0.0
     */
    public function getConnectionTimeout()
    {
        return $this->connection_timeout;
    }

    private function createHeader()
    {
        $headers = $this->headers;
        $headers['Authorization'] = 'Bearer ' . $this->apiKey;

        return $headers;
    }

    protected function getQuery($action, $arguments, $throw=false)
    {
        $host = $this->getHost();
        $client = new Client(['base_uri' => $host]);

        try{
            $response = $client->get('/v1/' . $action, [
                'headers' => $this->createHeader(),
                // 'body'    => $arguments[0],
                'verify' => false,
                'query' => $arguments,
                'timeout' => $this->getTimeout(),
                'connect_timeout' => $this->getConnectionTimeout()
            ]);

            return json_decode((string) $response->getBody());
        }
        catch(\GuzzleHttp\Exception\ClientException $e)
        {
            if ($throw) {
                throw $e;
            }
            return $e->getMessage();
        }
    }

    protected function postQuery($action, $arguments, $throw=false)
    {
        $host = $this->getHost();
        $client = new Client(['base_uri' => $host]);

        try{
            $response = $client->post('/v1/' . $action, [
                'headers' => $this->createHeader(),
                // 'body'    => $arguments[0],
                'verify' => false,
                'query' => $arguments,
                'timeout' => $this->getTimeout(),
                'connect_timeout' => $this->getConnectionTimeout()
            ]);

            //return json_decode((string) $response->getBody());
            return (string) $response->getBody();
        }
        catch(\GuzzleHttp\Exception\ClientException $e)
        {
            if ($throw) {
                throw $e;
            }
            return $e->getMessage();
        }
    }
}