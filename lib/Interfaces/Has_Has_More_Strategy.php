<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Abstracts\Has_More_Strategy;

interface Has_Has_More_Strategy
{
    /**
     * Get the collection.
     *
     * @return Has_More_Strategy
     */
    public function get_has_more_strategy(): Has_More_Strategy;

    /**
     * Sets the collection.
     *
     * @param Has_More_Strategy $content_model_instance
     * @return static
     */
    public function set_has_more_strategy(Has_More_Strategy $content_model_instance): static;
}