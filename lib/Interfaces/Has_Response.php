<?php

namespace Adiungo\Core\Interfaces;

interface Has_Response
{
    /**
     * Gets the data source
     * @return string
     */
    public function get_response(): string;

    /**
     * Sets the data source
     * @param string $response
     * @return $this
     */
    public function set_response(string $response): static;
}