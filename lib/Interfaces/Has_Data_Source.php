<?php

namespace Adiungo\Core\Interfaces;

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Traits\With_Data_Source;

/**
 * @see With_Data_Source
 */
interface Has_Data_Source
{
    /**
     * Gets the data source
     * @return Data_Source
     */
    public function get_data_source(): Data_Source;

    /**
     * Sets the data source
     * @param Data_Source $data_source
     * @return $this
     */
    public function set_data_source(Data_Source $data_source): static;
}
