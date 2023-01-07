<?php

namespace Adiungo\Core\Traits;

use Underpin\Factories\Url;

trait With_Base
{
    protected Url $base;

    /**
     * Gets the base
     *
     * @return Url
     */
    public function get_base(): Url
    {
        return $this->base;
    }

    /**
     * Sets the base
     *
     * @param Url $base The base to set.
     * @return $this
     */
    public function set_base(Url $base): static
    {
        $this->base = $base;

        return $this;
    }
}
