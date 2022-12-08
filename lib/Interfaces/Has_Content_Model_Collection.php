<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Collections\Content_Model_Collection;

interface Has_Content_Model_Collection
{
    /**
     * Get the collection.
     *
     * @return Content_Model_Collection
     */
    public function get_content_model_collection(): Content_Model_Collection;

    /**
     * Sets the collection.
     *
     * @param Content_Model_Collection $content_model_instance
     * @return static
     */
    public function set_content_model_collection(Content_Model_Collection $content_model_instance): static;
}