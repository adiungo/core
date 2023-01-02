<?php

namespace Adiungo\Core\Tests\Unit\Traits;

use Adiungo\Core\Traits\With_Remote_Id;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Remote_Id::set_remote_id
 * @covers \Adiungo\Core\Traits\With_Remote_Id::get_remote_id
 */
class With_Remote_Id_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Remote_Id::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'remote_Id' => ['set_remote_id', 'get_remote_id', 1988];
    }
}
