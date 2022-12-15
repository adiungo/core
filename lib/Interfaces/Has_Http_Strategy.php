<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Abstracts\Http_Strategy;

interface Has_Http_Strategy
{
    /**
     * Get the collection.
     *
     * @return Http_Strategy
     */
    public function get_http_strategy(): Http_Strategy;

    /**
     * Sets the collection.
     *
     * @param Http_Strategy $http_strategy
     * @return static
     */
    public function set_http_strategy(Http_Strategy $http_strategy): static;
}