<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Tests\Test_Case;
use Adiungo\Core\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Adiungo\Core\Traits\With_Origin;
use Generator;
use Mockery;
use Underpin\Factories\Url;

/**
 * @covers \Adiungo\Core\Traits\With_Origin::set_origin
 * @covers \Adiungo\Core\Traits\With_Origin::get_origin
 */
class With_Origin_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Origin::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'origin' => ['set_origin', 'get_origin', Mockery::mock(Url::class)];
    }
}