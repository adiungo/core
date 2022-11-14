<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Collections\Content_Model_Collection;

interface Data_Source
{

    /**
     * Fetches the data for this source.
     *
     * @return Content_Model_Collection
     */
    public function get_data(): Content_Model_Collection;

    /**
     * Returns true if there is more un-indexed content to fetch.
     *
     * @return bool
     */
    public function has_more(): bool;

    /**
     * Sets up a new instance of data source that will fetch the next page of data from the source.
     *
     * @return Data_Source
     */
    public function get_next(): Data_Source;
}