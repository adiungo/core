<?php

namespace Adiungo\Core\Traits;


use Adiungo\Core\Interfaces\Has_Paginated_Request;

trait With_Single_Request_Builder
{
    /**
     * @var Has_Paginated_Request
     */
    protected Has_Paginated_Request $single_request_builder;

    /**
     * Get the collection that this class can set.
     *
     * @return Has_Paginated_Request
     */
    public function get_single_request_builder(): Has_Paginated_Request
    {
        return $this->single_request_builder;
    }

    /**
     * Sets the collection that this class can set.
     *
     * @param Has_Paginated_Request $single_request_builder
     * @return static
     */
    public function set_single_request_builder(Has_Paginated_Request $single_request_builder): static
    {
        $this->single_request_builder = $single_request_builder;

        return $this;
    }
}