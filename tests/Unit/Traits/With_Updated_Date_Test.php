<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Traits\With_Updated_Date;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use DateTime;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Updated_Date::set_updated_date
 * @covers \Adiungo\Core\Traits\With_Updated_Date::get_updated_date
 */
class With_Updated_Date_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Updated_Date::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'updated_date' => ['set_updated_date', 'get_updated_date', Mockery::mock(DateTime::class)];
    }
}