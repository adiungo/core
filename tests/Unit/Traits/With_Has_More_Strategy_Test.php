<?php

namespace Adiungo\Core\Tests\Unit\Traits;

use Adiungo\Core\Abstracts\Has_More_Strategy;
use Adiungo\Core\Traits\With_Has_More_Strategy;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Has_More_Strategy::set_author
 * @covers \Adiungo\Core\Traits\With_Has_More_Strategy::get_author
 */
class With_Has_More_Strategy_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Has_More_Strategy::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'content-model-instance' => ['set_has_more_strategy', 'get_has_more_strategy', Mockery::mock(Has_More_Strategy::class)];
    }
}
