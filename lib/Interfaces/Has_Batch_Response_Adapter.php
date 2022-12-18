<?php

namespace Adiungo\Core\Interfaces;

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Abstracts\Batch_Response_Adapter;

interface Has_Batch_Response_Adapter
{
    /**
     * Gets the data source adapter.
     *
     * @return Batch_Response_Adapter
     */
    public function get_batch_response_adapter(): Batch_Response_Adapter;

    /**
     * Sets the data source adapter
     *
     * @param Batch_Response_Adapter $batch_response_adapter
     * @return $this
     */
    public function set_batch_response_adapter(Batch_Response_Adapter $batch_response_adapter): static;
}
