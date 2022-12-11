<?php

namespace Adiungo\Core\Traits;


use Adiungo\Core\Abstracts\Int_Id_Based_Request_Builder;
use Adiungo\Core\Abstracts\String_Id_Based_Request_Builder;

trait With_Single_Request_Builder
{
    /**
     * @var Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder
     */
    protected Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder $single_request_builder;

    /**
     * Get the collection that this class can set.
     *
     * @return Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder
     */
    public function get_single_request_builder(): Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder
    {
        return $this->single_request_builder;
    }

    /**
     * Sets the collection that this class can set.
     *
     * @param Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder $single_request_builder
     * @return static
     */
    public function set_single_request_builder(Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder $single_request_builder): static
    {
        $this->single_request_builder = $single_request_builder;

        return $this;
    }
}