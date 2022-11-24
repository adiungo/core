<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Abstracts\Content_Model;

interface Has_Content_Model_Instance
{
    /**
     * Get the instance that this class can set.
     *
     * @return class-string<Content_Model>
     */
    public function get_content_model_instance(): string;

    /**
     * Sets the instance that this class can set.
     *
     * @param class-string<Content_Model> $content_model_instance
     * @return static
     */
    public function set_content_model_instance(string $content_model_instance): static;
}