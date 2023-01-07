<?php

namespace Adiungo\Core\Factories\Has_More_Strategies;

use Adiungo\Core\Abstracts\Has_More_Strategy;

class Has_All_Ids_Strategy extends Has_More_Strategy
{
    /**
     * @param int $per_page The maximum number of items fetched per request.
     * @param int $requested_count The total number of items requested.
     */
    public function __construct(protected int $per_page, protected int $requested_count)
    {
    }

    /**
     * Returns true if The collection count is equal to the items per page setting.
     *
     * @return bool
     */
    protected function collection_count_is_equal_to_items_per_page(): bool
    {
        return count($this->get_content_model_collection()->to_array()) === $this->per_page;
    }

    /**
     * Returns true if The collection count is equal to the requested count.
     *
     * @return bool
     */
    protected function collection_count_is_equal_to_requested_count(): bool
    {
        return count($this->get_content_model_collection()->to_array()) === $this->requested_count;
    }

    /**
     * @inheritDoc
     */
    public function has_more(): bool
    {
        if ($this->collection_count_is_equal_to_items_per_page()) {
            return false;
        }

        if ($this->collection_count_is_equal_to_requested_count()) {
            return false;
        }

        return true;
    }
}
