<?php

namespace Adiungo\Core\Tests\Unit\Traits;

use Adiungo\Core\Traits\With_Last_Requested_Date;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use DateTime;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Last_Requested_Date::set_last_requested_date
 * @covers \Adiungo\Core\Traits\With_Last_Requested_Date::get_last_requested_date
 */
class With_Last_Requested_Date_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Last_Requested_Date::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'last_requested_date' => ['set_last_requested_date', 'get_last_requested_date', Mockery::mock(DateTime::class)];
    }
}
