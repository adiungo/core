<?php

namespace Adiungo\Core\Tests\Unit\Abstracts;

use Adiungo\Core\Abstracts\Offset_Based_Batch_Builder;
use Adiungo\Tests\Test_Case;
use Mockery;

class Offset_Based_Batch_Builder_Test extends Test_Case
{
    public function test_can_get_next(): void
    {
        $instance = Mockery::mock(Offset_Based_Batch_Builder::class)->makePartial();

        $instance->allows('get_limit')->andReturn(15);
        $instance->allows('get_offset')->andReturn(10);
        $instance->expects('set_offset')->with(25)->andReturn($instance);

        $this->assertSame($instance->get_next(), $instance);
    }
}
