<?php

namespace Adiungo\Core\Tests\Unit\Factories\Adapters;

use Adiungo\Core\Adapters\Basic_Single_Response_Adapter;
use Adiungo\Tests\Test_Case;
use Underpin\Exceptions\Operation_Failed;

class Basic_Single_Response_Adapter_Test extends Test_Case
{
    /**
     * @covers \Adiungo\Core\Adapters\Basic_Batch_Response_Adapter::to_array
     *
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_convert_to_array(): void
    {
        $result = (new Basic_Single_Response_Adapter())->set_response('{"foo": "bar"}')->to_array();

        $this->assertSame(['foo' => 'bar'], $result);
    }
}