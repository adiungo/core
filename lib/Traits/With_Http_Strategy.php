<?php

namespace Adiungo\Core\Traits;

use Adiungo\Core\Abstracts\Http_Strategy;

/**
 * @see Has_Response
 */
trait With_Http_Strategy
{
    protected Http_Strategy $http_strategy;

    /**
     * Gets the index strategy.
     *
     * @return Http_Strategy
     */
    public function get_http_strategy(): Http_Strategy
    {
        return $this->http_strategy;
    }

    /**
     * Sets the index strategy.
     *
     * @param Http_Strategy $http_strategy
     * @return $this
     */
    public function set_http_strategy(Http_Strategy $http_strategy): static
    {
        $this->http_strategy = $http_strategy;

        return $this;
    }

}