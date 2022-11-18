<?php

namespace Adiungo\Core\Interfaces;

interface Has_Author
{

    /**
     * Gets the author
     *
     * @return string
     */
    public function get_author(): string;

    /**
     * Sets the author
     *
     * @param string $author The author to set.
     * @return $this
     */
    public function set_author(string $author): static;
}