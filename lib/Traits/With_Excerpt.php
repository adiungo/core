<?php

namespace Adiungo\Core\Traits;


namespace Adiungo\Core\Traits;

trait With_Excerpt
{

    protected string $excerpt;

    /**
     * Gets the excerpt
     *
     * @return String
     */
    public function get_excerpt(): string
    {
        return $this->excerpt;
    }

    /**
     * Sets the excerpt
     *
     * @param String $excerpt The excerpt to set.
     * @return $this
     */
    public function set_excerpt(string $excerpt): static
    {
        $this->excerpt = $excerpt;

        return $this;
    }

}