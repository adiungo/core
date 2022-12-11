<?php

namespace Adiungo\Core\Traits;


use Adiungo\Core\Abstracts\Has_More_Strategy;

trait With_Has_More_Strategy
{
    /**
     * @var Has_More_Strategy
     */
    protected Has_More_Strategy $has_more_strategy;

    /**
     * Get the collection that this class can set.
     *
     * @return Has_More_Strategy
     */
    public function get_has_more_strategy(): Has_More_Strategy
    {
        return $this->has_more_strategy;
    }

    /**
     * Sets the collection that this class can set.
     *
     * @param Has_More_Strategy $has_more_strategy
     * @return static
     */
    public function set_has_more_strategy(Has_More_Strategy $has_more_strategy): static
    {
        $this->has_more_strategy = $has_more_strategy;

        return $this;
    }
}