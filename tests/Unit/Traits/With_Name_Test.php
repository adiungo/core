<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Traits\With_Name;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Name::set_name
 * @covers \Adiungo\Core\Traits\With_Name::get_name
 */
class With_Name_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Name::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'name' => ['set_name', 'get_name', 'foo'];
    }
}