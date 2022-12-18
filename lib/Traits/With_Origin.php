<?php

namespace Adiungo\Core\Traits;

namespace Adiungo\Core\Traits;

use Underpin\Factories\Url;

trait With_Origin
{
    protected Url $origin;

    /**
     * Gets the origin
     *
     * @return Url
     */
    public function get_origin(): Url
    {
        return $this->origin;
    }

    /**
     * Sets the origin
     *
     * @param Url $origin The origin to set.
     * @return $this
     */
    public function set_origin(Url $origin): static
    {
        $this->origin = $origin;

        return $this;
    }
}
