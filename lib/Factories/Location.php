<?php

namespace Adiungo\Core\Factories;


class Location
{

    public function __construct(protected float $latitude, protected float $longitude)
    {

    }

    /**
     * Gets the latitude of this location
     *
     * @return float
     */
    public function get_latitude(): float
    {
        return $this->latitude;
    }

    /**
     * Gets the longitude of this location.
     *
     * @return float
     */
    public function get_longitude(): float
    {
        return $this->longitude;
    }

}