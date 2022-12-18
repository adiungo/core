<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Factories\Location;

interface Has_Location
{
    /**
     * Gets the location
     *
     * @return Location
     */
    public function get_location(): Location;

    /**
     * Sets the location
     *
     * @param Location $location The location to set.
     * @return $this
     */
    public function set_location(Location $location): static;
}
