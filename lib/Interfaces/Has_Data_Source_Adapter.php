<?php

namespace Adiungo\Core\Interfaces;

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Factories\Adapters\Data_Source_Adapter;

interface Has_Data_Source_Adapter
{
    /**
     * Gets the data source adapter.
     *
     * @return Data_Source_Adapter
     */
    public function get_data_source_adapter(): Data_Source_Adapter;

    /**
     * Sets the data source adapter
     *
     * @param Data_Source_Adapter $data_source_adapter
     * @return $this
     */
    public function set_data_source_adapter(Data_Source_Adapter $data_source_adapter): static;
}
