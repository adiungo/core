<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Abstracts\Int_Id_Based_Request_Builder;
use Adiungo\Core\Abstracts\String_Id_Based_Request_Builder;

interface Has_Single_Request_Builder
{
    /**
     * Get the collection.
     *
     * @return Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder
     */
    public function get_single_request_builder(): Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder;

    /**
     * Sets the collection.
     *
     * @param Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder $content_model_instance
     * @return static
     */
    public function set_single_request_builder(Int_Id_Based_Request_Builder|String_Id_Based_Request_Builder $content_model_instance): static;
}