<?php

namespace Adiungo\Core\Interfaces;

interface Has_Batch_Request_Builder
{
    /**
     * Get the collection.
     *
     * @return Has_Paginated_Request
     */
    public function get_batch_request_builder(): Has_Paginated_Request;

    /**
     * Sets the collection.
     *
     * @param Has_Paginated_Request $content_model_instance
     * @return static
     */
    public function set_batch_request_builder(Has_Paginated_Request $content_model_instance): static;
}