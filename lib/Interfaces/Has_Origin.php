<?php

namespace Adiungo\Core\Interfaces;

use Underpin\Factories\Url;

interface Has_Origin
{

    /**
     * Gets the origin
     *
     * @return Url
     */
    public function get_origin(): Url;

    /**
     * Sets the origin
     *
     * @param Url $origin The origin to set.
     * @return $this
     */
    public function set_origin(Url $origin): static;
}