<?php

namespace Adiungo\Core\Traits;

namespace Adiungo\Core\Traits;

trait With_Slug
{
    protected string $slug;

    /**
     * Gets the slug
     *
     * @return String
     */
    public function get_slug(): string
    {
        return $this->slug;
    }

    /**
     * Sets the slug
     *
     * @param String $slug The slug to set.
     * @return $this
     */
    public function set_slug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
