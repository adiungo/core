<?php

namespace Adiungo\Core\Tests\Unit\Abstracts;

use Adiungo\Core\Abstracts\Page_Based_Batch_Builder;
use Adiungo\Tests\Test_Case;
use Mockery;

class Page_Based_Batch_Builder_Test extends Test_Case
{
    public function test_can_get_next(): void
    {
        $instance = Mockery::mock(Page_Based_Batch_Builder::class)->makePartial();

        $instance->allows('get_page')->andReturn(2);
        $instance->expects('set_page')->with(3)->andReturn($instance);

        $this->assertSame($instance->get_next(), $instance);
    }
}
