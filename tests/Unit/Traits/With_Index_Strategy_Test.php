<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Factories\Index_Strategy;
use Adiungo\Core\Tests\Test_Case;
use Adiungo\Core\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Adiungo\Core\Traits\With_Index_Strategy;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Index_Strategy::set_index_strategy
 * @covers \Adiungo\Core\Traits\With_Index_Strategy::get_index_strategy
 */
class With_Index_Strategy_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Index_Strategy::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'index_strategy' => ['set_index_strategy', 'get_index_strategy', Mockery::mock(Index_Strategy::class)];
    }
}