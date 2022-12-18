<?php

namespace Adiungo\Core\Abstracts;

use Adiungo\Core\Events\Content_Model_Event;
use Adiungo\Core\Events\Providers\Content_Model_Provider;
use Underpin\Interfaces\Identifiable;
use Underpin\Interfaces\Model;

abstract class Content_Model implements Model, Identifiable
{
    /**
     * Gets the content model event.
     *
     * @return Content_Model_Event
     */
    protected function get_content_model_event(): Content_Model_Event
    {
        return Content_Model_Event::instance();
    }

    /**
     * Creates a content model provider, and provides the current instance.
     *
     * @return Content_Model_Provider
     */
    protected function get_content_model_provider(): Content_Model_Provider
    {
        return new Content_Model_Provider($this);
    }

    /**
     * Saves this model.
     *
     * @return $this
     */
    public function save(): static
    {
        $this->get_content_model_event()->broadcast('save', $this->get_content_model_provider());
        return $this;
    }

    /**
     * Delete this model.
     *
     * @return $this
     */
    public function delete(): static
    {
        $this->get_content_model_event()->broadcast('delete', $this->get_content_model_provider());
        return $this;
    }
}
