<?php

namespace Adiungo\Core\Abstracts;


use Adiungo\Core\Interfaces\Has_Limit;
use Adiungo\Core\Interfaces\Has_Offset;
use Adiungo\Core\Interfaces\Has_Paginated_Request;
use Underpin\Traits\With_Request;

abstract class Offset_Based_Batch_Builder implements Has_Limit, Has_Offset, Has_Paginated_Request
{
    use With_Request;

    /**
     * Gets the request for the next page.
     * @return $this
     */
    public function get_next(): static
    {
        return $this->set_offset($this->get_offset() + $this->get_limit());
    }
}