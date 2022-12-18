<?php

namespace Adiungo\Core\Interfaces;

use Underpin\Interfaces\Has_Request;

interface Has_Paginated_Request extends Has_Request
{
    /**
     * Gets the request for the next page.
     * @return $this
     */
    public function get_next(): static;
}
