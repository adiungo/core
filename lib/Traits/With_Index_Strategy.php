<?php

namespace Adiungo\Core\Traits;


use Adiungo\Core\Factories\Index_Strategy;

trait With_Index_Strategy
{
    protected Index_Strategy $index_strategy;

    /**
     * Gets the index strategy.
     *
     * @return Index_Strategy
     */
    public function get_index_strategy(): Index_Strategy
    {
        return $this->index_strategy;
    }

    /**
     * Sets the index strategy.
     *
     * @param Index_Strategy $index_strategy
     * @return $this
     */
    public function set_index_strategy(Index_Strategy $index_strategy): static
    {
        $this->index_strategy = $index_strategy;

        return $this;
    }

}