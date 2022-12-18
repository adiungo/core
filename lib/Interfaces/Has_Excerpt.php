<?php

namespace Adiungo\Core\Interfaces;

interface Has_Excerpt
{
    /**
     * Gets the excerpt
     *
     * @return string
     */
    public function get_excerpt(): string;

    /**
     * Sets the excerpt
     *
     * @param string $excerpt The excerpt to set.
     * @return $this
     */
    public function set_excerpt(string $excerpt): static;
}
