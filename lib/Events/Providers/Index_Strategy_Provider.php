<?php

namespace Adiungo\Core\Events\Providers;


use Adiungo\Core\Factories\Index_Strategy;
use Underpin\Interfaces\Data_Provider;

class Index_Strategy_Provider implements Data_Provider
{
    /**
     * Constructor.
     *
     * @param Index_Strategy $index_strategy
     */
    public function __construct(protected Index_Strategy $index_strategy)
    {

    }

    /**
     * Gets the content model provided by this class.
     *
     * @return Index_Strategy
     */
    public function get_index_strategy(): Index_Strategy
    {
        return $this->index_strategy;
    }
}