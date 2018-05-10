<?php
namespace Mtigdemir\Github\Test\Client;

use Mtigdemir\Github\Http\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testPerPage()
    {
        $client = new Client();

        $result = $client->get('search/repositories', [
            'q' => 'test',
            'per_page' => 50
        ]);

        $items = json_decode($result,true)['items'];

        // Default Count 30 -- per_page should return more than 30 items for each query
        $this->assertGreaterThan(30,count($items));
        $this->assertEquals(50, count($items));
    }

}
