<?php

namespace Adiungo\Core\Tests\Unit\Factories\Adapters;

use Adiungo\Core\Adapters\Basic_Batch_Response_Adapter;
use Adiungo\Tests\Test_Case;
use Generator;
use Underpin\Exceptions\Operation_Failed;

class Basic_Batch_Response_Adapter_Test extends Test_Case
{
    /**
     * @covers       \Adiungo\Core\Adapters\Basic_Batch_Response_Adapter::to_array
     *
     * @param string $response
     * @param mixed[][] $expected
     * @return void
     * @throws Operation_Failed
     * @dataProvider provider_can_convert_to_array
     */
    public function test_can_convert_to_array(string $response, array $expected): void
    {
        $result = (new Basic_Batch_Response_Adapter())->set_response($response)->to_array();

        $this->assertSame($expected, $result);
    }

    public function provider_can_convert_to_array(): Generator
    {
        yield 'objects get converted to array of objects' => ['{"foo": {"bar": "baz"}}', [['foo' => ['bar' => 'baz']]]];
        yield 'arrays of objects remain array of objects' => ['[{"foo": {"bar": "baz"}},{"bar": {"foo": "baz"}}]', [['foo' => ['bar' => 'baz']], ['bar' => ['foo' => 'baz']]]];
    }
}