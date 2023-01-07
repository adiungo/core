<?php

namespace Adiungo\Core\Interfaces;

use Underpin\Factories\Url;

interface Has_Base
{
    /**
     * Gets the base
     *
     * @return Url
     */
    public function get_base(): Url;

    /**
     * Sets the base
     *
     * @param Url $base The base to set.
     * @return $this
     */
    public function set_base(Url $base): static;
}
