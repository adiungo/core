<?php

namespace Adiungo\Core\Traits;


namespace Adiungo\Core\Traits;

trait With_Content
{

    protected string $content;

    /**
     * Gets the content
     *
     * @return String
     */
    public function get_content(): string
    {
        return $this->content;
    }

    /**
     * Sets the content
     *
     * @param String $content The content to set.
     * @return $this
     */
    public function set_content(string $content): static
    {
        $this->content = $content;

        return $this;
    }

}