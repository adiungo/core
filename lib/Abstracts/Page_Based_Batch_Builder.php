<?php

namespace Adiungo\Core\Abstracts;

use Adiungo\Core\Interfaces\Has_Page;
use Adiungo\Core\Interfaces\Has_Paginated_Request;
use Underpin\Traits\With_Request;

abstract class Page_Based_Batch_Builder implements Has_Page, Has_Paginated_Request
{
    use With_Request;

    /**
     * Gets the request for the next page.
     * @return $this
     */
    public function get_next(): static
    {
        return $this->set_page($this->get_page() + 1);
    }
}
