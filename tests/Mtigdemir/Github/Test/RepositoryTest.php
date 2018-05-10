<?php

namespace Mtigdemir\Github\Test;

use Mtigdemir\Github\Http\Client;
use Mtigdemir\Github\Repository;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    /**
     * @var Repository
     */
    protected $repository;

    protected function setUp()
    {
        parent::setUp();
        $client = new Client();
        $this->repository = new Repository($client);
    }

    public function testQueryBuilder()
    {
        $result = $this->repository->queryBuilder('in', 'description', 'testing');

        $this->assertEquals("testing{in:description}", $result);
    }

    public function testSearchWhereInDescription()
    {
        $result = $this->repository->searchIn('description', 'shampoo');

        $this->assertArrayHasKey('items', $this->convertToArray($result));

        // Item Should contains search keyword in description
        $firstItem = json_decode($result, true)['items'][0];
        $this->assertContains('shampoo',$firstItem['description']);
    }

    public function testRepositorySearch()
    {
        $result = $this->repository->search('shampoo');
        $this->assertArrayHasKey('items', json_decode($result, true));
    }

    private function convertToArray($json)
    {
        return json_decode($json, true);
    }
}
