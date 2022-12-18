<?php

namespace Adiungo\Core\Tests\Unit\Traits;

use Adiungo\Core\Factories\Location;
use Adiungo\Core\Traits\With_Location;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Simple_Setter_Getter_Tests;
use Generator;
use Mockery;

/**
 * @covers \Adiungo\Core\Traits\With_Location::set_location
 * @covers \Adiungo\Core\Traits\With_Location::get_location
 */
class With_Location_Test extends Test_Case
{
    use With_Simple_Setter_Getter_Tests;

    public function setUp(): void
    {
        parent::setUp();
        $this->instance = Mockery::mock(With_Location::class);
        $this->instance->shouldAllowMockingProtectedMethods()->makePartial();
    }

    protected function get_setters_and_getters(): Generator
    {
        yield 'location' => ['set_location', 'get_location', Mockery::mock(Location::class)];
    }
}
