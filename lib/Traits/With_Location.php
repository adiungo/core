<?php

namespace Adiungo\Core\Traits;


namespace Adiungo\Core\Traits;

use Adiungo\Core\Factories\Location;

trait With_Location
{

    protected Location $location;

    /**
     * Gets the location
     *
     * @return Location
     */
    public function get_location(): Location
    {
        return $this->location;
    }

    /**
     * Sets the location
     *
     * @param Location $location The location to set.
     * @return $this
     */
    public function set_location(Location $location): static
    {
        $this->location = $location;

        return $this;
    }

}