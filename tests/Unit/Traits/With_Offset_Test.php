<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Traits\With_Offset;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Offset::set_offset
 * @covers \Adiungo\Core\Traits\With_Offset::get_offset
 */
class With_Offset_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Offset::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'offset' => ['set_offset', 'get_offset', 1988];
    }
}