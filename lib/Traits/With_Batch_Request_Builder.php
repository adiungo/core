<?php

namespace Adiungo\Core\Traits;


use Adiungo\Core\Interfaces\Has_Paginated_Request;

trait With_Batch_Request_Builder
{
    /**
     * @var Has_Paginated_Request
     */
    protected Has_Paginated_Request $batch_request_builder;

    /**
     * Get the collection that this class can set.
     *
     * @return Has_Paginated_Request
     */
    public function get_batch_request_builder(): Has_Paginated_Request
    {
        return $this->batch_request_builder;
    }

    /**
     * Sets the collection that this class can set.
     *
     * @param Has_Paginated_Request $batch_request_builder
     * @return static
     */
    public function set_batch_request_builder(Has_Paginated_Request $batch_request_builder): static
    {
        $this->batch_request_builder = $batch_request_builder;

        return $this;
    }
}