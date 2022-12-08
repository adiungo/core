<?php

namespace Adiungo\Core\Traits;


use Adiungo\Core\Collections\Content_Model_Collection;

trait With_Content_Model_Collection
{
    /**
     * @var Content_Model_Collection
     */
    protected Content_Model_Collection $content_model_collection;

    /**
     * Get the collection that this class can set.
     *
     * @return Content_Model_Collection
     */
    public function get_content_model_collection(): Content_Model_Collection
    {
        return $this->content_model_collection;
    }

    /**
     * Sets the collection that this class can set.
     *
     * @param Content_Model_Collection $content_model_collection
     * @return static
     */
    public function set_content_model_collection(Content_Model_Collection $content_model_collection): static
    {
        $this->content_model_collection = $content_model_collection;

        return $this;
    }
}