<?php

namespace Adiungo\Core\Interfaces;

interface Has_Page
{
    /**
     * Gets the page
     *
     * @return int
     */
    public function get_page(): int;

    /**
     * Sets the page
     *
     * @param int $page The page to set.
     * @return $this
     */
    public function set_page(int $page): static;
}
