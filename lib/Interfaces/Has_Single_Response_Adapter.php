<?php

namespace Adiungo\Core\Interfaces;

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Abstracts\Single_Response_Adapter;

interface Has_Single_Response_Adapter
{
    /**
     * Gets the data source adapter.
     *
     * @return Single_Response_Adapter
     */
    public function get_single_response_adapter(): Single_Response_Adapter;

    /**
     * Sets the data source adapter
     *
     * @param Single_Response_Adapter $single_response_adapter
     * @return $this
     */
    public function set_single_response_adapter(Single_Response_Adapter $single_response_adapter): static;
}
