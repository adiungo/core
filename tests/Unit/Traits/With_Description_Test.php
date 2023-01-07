<?php

namespace Adiungo\Core\Tests\Unit\Traits;

use Adiungo\Core\Traits\With_Description;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Description::set_description
 * @covers \Adiungo\Core\Traits\With_Description::get_description
 */
class With_Description_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Description::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'description' => ['set_description', 'get_description', 'hello world!'];
    }
}
