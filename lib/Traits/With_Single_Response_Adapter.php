<?php

namespace Adiungo\Core\Traits;

use Adiungo\Core\Abstracts\Single_Response_Adapter;

trait With_Single_Response_Adapter
{
    /**
     * @var Single_Response_Adapter
     */
    protected Single_Response_Adapter $single_response_adapter;

    /**
     * Get the collection that this class can set.
     *
     * @return Single_Response_Adapter
     */
    public function get_single_response_adapter(): Single_Response_Adapter
    {
        return $this->single_response_adapter;
    }

    /**
     * Sets the collection that this class can set.
     *
     * @param Single_Response_Adapter $single_response_adapter
     * @return static
     */
    public function set_single_response_adapter(Single_Response_Adapter $single_response_adapter): static
    {
        $this->single_response_adapter = $single_response_adapter;

        return $this;
    }
}
