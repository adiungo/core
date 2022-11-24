<?php

namespace Adiungo\Core\Traits;


namespace Adiungo\Core\Traits;

trait With_Limit
{

    protected int $limit;

    /**
     * Gets the limit
     *
     * @return Int
     */
    public function get_limit(): int
    {
        return $this->limit;
    }

    /**
     * Sets the limit
     *
     * @param Int $limit The limit to set.
     * @return $this
     */
    public function set_limit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

}