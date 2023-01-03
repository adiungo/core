<?php

namespace Adiungo\Core\Abstracts;

use Adiungo\Core\Events\Content_Model_Bind_Event;
use Adiungo\Core\Events\Content_Model_Event;
use Adiungo\Core\Events\Providers\Content_Model_Binding_Provider;
use Adiungo\Core\Events\Providers\Content_Model_Provider;
use Adiungo\Core\Factories\Category;
use Adiungo\Core\Factories\Tag;
use Adiungo\Core\Interfaces\Has_Attachments;
use Adiungo\Core\Interfaces\Has_Categories;
use Adiungo\Core\Interfaces\Has_Tags;
use Underpin\Interfaces\Identifiable;
use Underpin\Interfaces\Model;

abstract class Content_Model implements Model, Identifiable
{
    /**
     * Broadcasts events for related content.
     *
     * @param string $action
     * @return void
     */
    protected function broadcast_binding_events(string $action): void
    {
        if ($this instanceof Has_Categories) {
            $this->get_categories()->each(fn (Category $category) => $this->broadcast_model_bind_event($action, $category));
        }

        if ($this instanceof Has_Tags) {
            $this->get_tags()->each(fn (Tag $tag) => $this->broadcast_model_bind_event($action, $tag));
        }

        if ($this instanceof Has_Attachments) {
            $this->get_attachments()->each(fn (Attachment $attachment) => $this->broadcast_model_bind_event($action, $attachment));
        }
    }

    /**
     * Gets the broadcast model bind event.
     *
     * @param string $action
     * @param Content_Model $model
     * @return void
     */
    protected function broadcast_model_bind_event(string $action, Content_Model $model): void
    {
        $this->get_content_model_bind_event_instance()->broadcast($action, new Content_Model_Binding_Provider($this, $model));
    }

    /**
     * Gets the content model event.
     *
     * @return Content_Model_Bind_Event
     */
    protected function get_content_model_bind_event_instance(): Content_Model_Bind_Event
    {
        return Content_Model_Bind_Event::instance();
    }

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
        $this->broadcast_binding_events('save');

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
        $this->broadcast_binding_events('delete');

        return $this;
    }
}
