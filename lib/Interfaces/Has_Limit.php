<?php

namespace Adiungo\Core\Interfaces;

interface Has_Limit
{

    /**
     * Gets the limit
     *
     * @return int
     */
    public function get_limit(): int;

    /**
     * Sets the limit
     *
     * @param int $limit The limit to set.
     * @return $this
     */
    public function set_limit(int $limit): static;
}