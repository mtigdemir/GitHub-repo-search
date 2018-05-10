<?php

namespace Mtigdemir\Github\Http;


class Client
{
    const URL = 'https://api.github.com/';
    protected $client;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this::URL,
        ]);

    }

    public function get($uri, array $params)
    {
        if (count($params) > 0) {
            $uri .= '?'.http_build_query($params);
        }

        return $this->client->get($uri)->getBody();
    }
}