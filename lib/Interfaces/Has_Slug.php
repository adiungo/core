<?php

namespace Adiungo\Core\Interfaces;

interface Has_Slug
{
    /**
     * Gets the slug
     *
     * @return string
     */
    public function get_slug(): string;

    /**
     * Sets the slug
     *
     * @param string $slug The slug to set.
     * @return $this
     */
    public function set_slug(string $slug): static;
}
