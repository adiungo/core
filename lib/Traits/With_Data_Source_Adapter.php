<?php

namespace Adiungo\Core\Traits;

use Adiungo\Core\Factories\Adapters\Data_Source_Adapter;

trait With_Data_Source_Adapter
{
    protected Data_Source_Adapter $data_source_adapter;

    /**
     * Gets the data source adapter.
     *
     * @return Data_Source_Adapter
     */
    public function get_data_source_adapter(): Data_Source_Adapter
    {
        return $this->data_source_adapter;
    }

    /**
     * Sets the data source adapter
     *
     * @param Data_Source_Adapter $data_source_adapter
     * @return $this
     */
    public function set_data_source_adapter(Data_Source_Adapter $data_source_adapter): static
    {
        $this->data_source_adapter = $data_source_adapter;

        return $this;
    }
}
