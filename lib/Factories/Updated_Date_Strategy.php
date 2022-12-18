<?php

namespace Adiungo\Core\Factories;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Abstracts\Has_More_Strategy;
use Adiungo\Core\Interfaces\Has_Updated_Date;
use Adiungo\Core\Traits\With_Updated_Date;
use Underpin\Enums\Direction;
use Underpin\Exceptions\Operation_Failed;

class Updated_Date_Strategy extends Has_More_Strategy implements Has_Updated_Date
{
    use With_Updated_Date;

    /**
     * @inheritdoc
     * @throws Operation_Failed
     */
    public function has_more(): bool
    {
        return $this->get_updated_date() >= $this->get_oldest_model()->get_updated_date();
    }

    /**
     * Fetches the oldest model in the collection.
     *
     * @return Content_Model&Has_Updated_Date
     * @throws Operation_Failed
     */
    public function get_oldest_model(): Has_Updated_Date
    {
        $collection = $this->get_content_model_collection()->query()->sort_by('updated_date', Direction::Descending)->get_results()->to_array();

        /** @var Content_Model&Has_Updated_Date $oldest_item */
        $oldest_item = array_pop($collection);

        return $oldest_item;
    }
}
