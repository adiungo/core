<?php

namespace Adiungo\Core\Traits;

use Adiungo\Core\Abstracts\Batch_Response_Adapter;

trait With_Batch_Response_Adapter
{
    /**
     * @var Batch_Response_Adapter
     */
    protected Batch_Response_Adapter $batch_response_adapter;

    /**
     * Get the collection that this class can set.
     *
     * @return Batch_Response_Adapter
     */
    public function get_batch_response_adapter(): Batch_Response_Adapter
    {
        return $this->batch_response_adapter;
    }

    /**
     * Sets the collection that this class can set.
     *
     * @param Batch_Response_Adapter $batch_response_adapter
     * @return static
     */
    public function set_batch_response_adapter(Batch_Response_Adapter $batch_response_adapter): static
    {
        $this->batch_response_adapter = $batch_response_adapter;

        return $this;
    }
}
