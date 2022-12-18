<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Factories\Index_Strategy;

interface Has_Index_Strategy
{
    /**
     * Gets the index strategy.
     *
     * @return Index_Strategy
     */
    public function get_index_strategy(): Index_Strategy;

    /**
     * Sets the index strategy.
     *
     * @param Index_Strategy $index_strategy
     * @return $this
     */
    public function set_index_strategy(Index_Strategy $index_strategy): static;
}
