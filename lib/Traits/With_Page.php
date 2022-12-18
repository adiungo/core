<?php

namespace Adiungo\Core\Traits;

trait With_Page
{
    protected int $page;

    /**
     * Gets the page
     *
     * @return Int
     */
    public function get_page(): int
    {
        return $this->page;
    }

    /**
     * Sets the page
     *
     * @param Int $page The page to set.
     * @return $this
     */
    public function set_page(int $page): static
    {
        $this->page = $page;

        return $this;
    }
}
