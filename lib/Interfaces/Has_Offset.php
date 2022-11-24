<?php

namespace Adiungo\Core\Interfaces;

interface Has_Offset
{

    /**
     * Gets the offset
     *
     * @return int
     */
    public function get_offset(): int;

    /**
     * Sets the offset
     *
     * @param int $offset The offset to set.
     * @return $this
     */
    public function set_offset(int $offset): static;
}