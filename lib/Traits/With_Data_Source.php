<?php

namespace Adiungo\Core\Traits;

namespace Adiungo\Core\Traits;

use Adiungo\Core\Interfaces\Data_Source;
use Adiungo\Core\Interfaces\Has_Data_Source;

/**
 * @see Has_Data_Source
 */
trait With_Data_Source
{
    protected Data_Source $data_source;

    public function get_data_source(): Data_Source
    {
        return $this->data_source;
    }

    public function set_data_source(Data_Source $data_source): static
    {
        $this->data_source = $data_source;

        return $this;
    }
}
