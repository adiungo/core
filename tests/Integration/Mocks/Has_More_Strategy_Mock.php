<?php

namespace Adiungo\Core\Tests\Integration\Mocks;


use Adiungo\Core\Abstracts\Has_More_Strategy;

class Has_More_Strategy_Mock extends Has_More_Strategy
{

    public function has_more(): bool
    {
        $items = $this->get_content_model_collection()->to_array();

        /** @var Test_Model $item */
        $item = array_pop($items);

        return $item->get_id() !== 10;
    }
}