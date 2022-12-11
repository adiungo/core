<?php

namespace Adiungo\Core\Interfaces;

interface Has_Single_Request_Builder
{
    /**
     * Get the collection.
     *
     * @return Has_Paginated_Request
     */
    public function get_single_request_builder(): Has_Paginated_Request;

    /**
     * Sets the collection.
     *
     * @param Has_Paginated_Request $content_model_instance
     * @return static
     */
    public function set_single_request_builder(Has_Paginated_Request $content_model_instance): static;
}