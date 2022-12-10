<?php

namespace Adiungo\Core\Abstracts;

use Adiungo\Core\Interfaces\Has_Content_Model_Collection;
use Adiungo\Core\Traits\With_Content_Model_Collection;

abstract class Has_More_Strategy implements Has_Content_Model_Collection
{
    use With_Content_Model_Collection;

    /**
     * Returns true if there is more data to fetch.
     *
     * @return bool
     */
    abstract public function has_more(): bool;
}