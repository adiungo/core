<?php

namespace Adiungo\Core\Tests\Unit\Factories;


use Adiungo\Core\Factories\Location;
use Adiungo\Tests\Test_Case;

class Location_Test extends Test_Case
{

    /**
     *
     * @covers \Adiungo\Core\Factories\Location::get_latitude
     * @covers \Adiungo\Core\Factories\Location::get_longitude
     * @covers \Adiungo\Core\Factories\Location::__construct
     * @return void
     */
    public function test_can_get_latitude_and_longitude(): void
    {
        // <3
        $latitude = 36.40725;
        $longitude = -105.57307;

        $location = new Location($latitude, $longitude);

        $this->assertSame($latitude, $location->get_latitude());
        $this->assertSame($longitude, $location->get_longitude());
    }

}