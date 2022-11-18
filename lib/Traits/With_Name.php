<?php

namespace Adiungo\Core\Traits;


namespace Adiungo\Core\Traits;

trait With_Name
{

    protected string $name;

    /**
     * Gets the name
     *
     * @return String
     */
    public function get_name(): string
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param String $name The name to set.
     * @return $this
     */
    public function set_name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

}