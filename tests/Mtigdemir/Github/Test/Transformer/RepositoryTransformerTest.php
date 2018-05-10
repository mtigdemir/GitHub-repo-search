<?php

namespace Mtigdemir\Github\Test\Transformer;

use Mtigdemir\Github\Transformer\RepositoryTransformer;
use PHPUnit\Framework\TestCase;

class RepositoryTransformerTest extends TestCase
{

    /**
     * @var RepositoryTransformer
     */
    private $transformer;

    protected function setUp()
    {
        parent::setUp();
        $this->transformer = new RepositoryTransformer();
    }

    public function testTransformShouldIncludeLanguageIdDescription()
    {
        $result = $this->transformer->convert($this->getDummyData()['items']);

        $this->assertEquals(2, count($result->getItems()));
    }

    public function testLanguageDataClearIfStringIsEmpty()
    {
        $data = [
            [
                'id' => 1,
                'language' => 'PHP'
            ],
            [
                'id' => 2,
                'language' => ''
            ]
        ];
        $result = $this->transformer->filterEmptyLanguages($data);

        $this->assertCount(1, $result);
        $this->assertEquals([
            [
                'id' => 1,
                'language' => 'PHP'
            ]
        ], $result);
    }

    public function testLanguageDataClearIfStringIsNull()
    {
        $data = [
            [
                'id' => 1,
                'language' => 'PHP'
            ],
            [
                'id' => 2,
                'language' => null
            ]
        ];
        $result = $this->transformer->filterEmptyLanguages($data);
        $this->assertCount(1, $result);

        $this->assertEquals([
            [
                'id' => 1,
                'language' => 'PHP'
            ]
        ], $result);
    }

    public function getDummyData()
    {
        return json_decode('{
    "total_count": 2,
    "incomplete_results": false,
    "items": [
        {
            "id": 124204399,
            "language": "PHP",
            "description": "shampoo-php"
        },
         {
            "id": 1111111,
            "language": "Java",
            "description": "shampoo-java"
        }
        ]}
        ', true);
    }
}
