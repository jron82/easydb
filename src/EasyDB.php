<?php

namespace EasyDB;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EasyDB
{
    public $client;
    public $connection;
    public $database;
    public $config;

    public function __construct(string $connection, array $config)
    {
        $this->client     = new Client();
        $this->connection = $connection;
        $this->config     = $config;
        $this->database   = $this->config[$this->connection]['dbname'];
    }

    /**
     * @param string $key
     * @return string
     */
    public function composeUrl($key = '')
    {
        $api  = 'https://app.easydb.io';

        if(empty($key))
        {
            $url = "{$api}/database/{$this->database}";
        }
        else
        {
            $url = "{$api}/database/{$this->database}/{$key}";
        }

        return $url;
    }

    /**
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        try
        {
            $response = $this->client->request('GET', $this->composeUrl($key), [
                'headers' => [
                    'token'      => $this->config[$this->connection]['token']
                ]
            ]);
        }
        catch (GuzzleException $e)
        {
            error_log($e->getMessage());

            return '';
        }

        $body = $response->getBody();

        return $body->getContents();
    }

    /**
     * @return string
     */
    public function list()
    {
        try
        {
            $response = $this->client->request('GET', $this->composeUrl(), [
                'headers' => [
                    'token'      => $this->config[$this->connection]['token']
                ]
            ]);

        }
        catch (GuzzleException $e)
        {
            error_log($e->getMessage());

            return '';
        }

        $body = $response->getBody();

        return $body->getContents();

    }

    /**
     * @param string $key
     * @param mixed $value
     * @return string
     */
    public function put($key, $value)
    {
        try
        {
            $response = $this->client->request('POST', $this->composeUrl($key), [
                'body' =>  json_encode(['value' => $value]),
                'headers' => [
                    'Content-Type'     => 'application/json',
                    'token'      => $this->config[$this->connection]['token']
                ],
            ]);
        }
        catch (GuzzleException $e)
        {
            error_log($e->getMessage());

            return '';
        }

        $body = $response->getBody();

        return $body->getContents();
    }

    /**
     * @param string $key
     * @return string
     */
    public function delete($key)
    {
        try
        {
            $response = $this->client->request('DELETE', $this->composeUrl($key), [
                'headers' => [
                    'token' => $this->config[$this->connection]['token']
                ]
            ]);
        }
        catch (GuzzleException $e)
        {
            error_log($e->getMessage());

            return '';
        }

        $body = $response->getBody();

        return $body->getContents();
    }
}