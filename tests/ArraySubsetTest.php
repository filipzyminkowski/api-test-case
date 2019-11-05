<?php


namespace GlobeGroup\Test;


use PHPUnit\Framework\TestCase;

class ArraySubsetTest extends TestCase
{
    /** @test */
    function test()
    {
    $input = [
        'totalCount' => 10,
        'pageCount' => 5,
        'items' => [
            [
                'title' => 'Title0',
                'lead' => 'Lead.0',
                'hero' => NULL,
                'heroDescription' => NULL,
                'category' =>
                    [
                        'name' => 'PUBLISHED',
                        'id' => 1,
                    ],
                'country' =>
                    [],
                'id' => 1,
                'publishedAt' => '2019-10-10T07:00:00+02:00',
            ],
            [
                'title' => 'Title1',
                'lead' => 'Lead.1',
                'hero' => NULL,
                'heroDescription' => NULL,
                'category' =>
                    [
                        'name' => 'PUBLISHED',
                        'id' => 1,
                    ],
                'country' =>
                    [],
                'id' => 2,
                'publishedAt' => '2019-10-10T07:00:00+02:00',
            ]
        ]
    ];

    $expected = json_decode('{"totalCount":10,"pageCount":5,"items":[{"title":"Title0","lead":"Lead.0","hero":null,"heroDescription":null,"category":{"name":"PUBLISHED","id":1},"country":[],"id":1,"publishedAt":"2019-10-10T07:00:00+02:00"},{"title":"Title1","lead":"Lead.1","hero":null,"heroDescription":null,"category":{"name":"PUBLISHED","id":1},"country":[],"id":2,"publishedAt":"2019-10-10T07:00:00+02:00"}]}', true);

    $this->assertSame($expected, $input);
    }
}