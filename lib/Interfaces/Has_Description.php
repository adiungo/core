<?php

namespace Adiungo\Core\Interfaces;

interface Has_Description
{
    /**
     * Gets the description
     *
     * @return string
     */
    public function get_description(): string;

    /**
     * Sets the description
     *
     * @param string $description The description to set.
     * @return $this
     */
    public function set_description(string $description): static;
}
