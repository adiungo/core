<?php

namespace Adiungo\Core\Traits;

use Adiungo\Core\Abstracts\Content_Model;

trait With_Content_Model_Instance
{
    /**
     * @var class-string<Content_Model>
     */
    protected string $content_model_instance;

    /**
     * Get the instance that this class can set.
     *
     * @return class-string<Content_Model>
     */
    public function get_content_model_instance(): string
    {
        return $this->content_model_instance;
    }

    /**
     * Sets the instance that this class can set.
     *
     * @param class-string<Content_Model> $content_model_instance
     * @return static
     */
    public function set_content_model_instance(string $content_model_instance): static
    {
        $this->content_model_instance = $content_model_instance;

        return $this;
    }
}
