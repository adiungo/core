<?php

namespace Adiungo\Core\Interfaces;

interface Has_Name
{
    /**
     * Gets the name
     *
     * @return string
     */
    public function get_name(): string;

    /**
     * Sets the name
     *
     * @param string $name The name to set.
     * @return $this
     */
    public function set_name(string $name): static;
}
