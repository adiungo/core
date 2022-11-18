<?php

namespace Adiungo\Core\Interfaces;

interface Has_Content
{

    /**
     * Gets the content
     *
     * @return string
     */
    public function get_content(): string;

    /**
     * Sets the content
     *
     * @param string $content The content to set.
     * @return $this
     */
    public function set_content(string $content): static;
}