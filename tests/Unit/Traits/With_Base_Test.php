<?php

namespace Adiungo\Core\Tests\Unit\Traits;

use Adiungo\Core\Traits\With_Base;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;
use Underpin\Factories\Url;

/**
 * @covers \Adiungo\Core\Traits\With_Base::set_base
 * @covers \Adiungo\Core\Traits\With_Base::get_base
 */
class With_Base_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Base::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'base' => ['set_base', 'get_base', Mockery::mock(Url::class)];
    }
}
