<?php

namespace Adiungo\Core\Tests\Unit\Traits;


use Adiungo\Core\Traits\With_Published_Date;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use DateTime;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Published_Date::set_published_date
 * @covers \Adiungo\Core\Traits\With_Published_Date::get_published_date
 */
class With_Published_Date_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Published_Date::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'published_date' => ['set_published_date', 'get_published_date', Mockery::mock(DateTime::class)];
    }
}