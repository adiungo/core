<?php

namespace Adiungo\Core\Traits;

namespace Adiungo\Core\Traits;

trait With_Description
{
    protected string $description;

    /**
     * Gets the description
     *
     * @return String
     */
    public function get_description(): string
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param String $description The description to set.
     * @return $this
     */
    public function set_description(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
