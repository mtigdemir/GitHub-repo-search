<?php

namespace Mtigdemir\Github;


use Mtigdemir\Github\Http\Client;

class Repository
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * RepositorySearch constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search($query)
    {
        return $this->client->get('search/repositories', ['q' => $query]);
    }

    public function searchIn($where, $searchData)
    {
        $searchQuery = $this->queryBuilder("in", $where, $searchData);
        return $this->search($searchQuery);
    }

    public function queryBuilder($filterType, $where, $searchData)
    {
        return $searchData . "{" . $filterType . ":" . $where . "}";
    }
}