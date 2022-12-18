<?php

namespace Adiungo\Core\Traits;

namespace Adiungo\Core\Traits;

trait With_Offset
{
    protected int $offset;

    /**
     * Gets the offset
     *
     * @return Int
     */
    public function get_offset(): int
    {
        return $this->offset;
    }

    /**
     * Sets the offset
     *
     * @param Int $offset The offset to set.
     * @return $this
     */
    public function set_offset(int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }
}
