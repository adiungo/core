<?php

namespace Adiungo\Core\Adapters;

use Adiungo\Core\Abstracts\Batch_Response_Adapter;
use JsonException;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Helpers\Array_Helper;

class Basic_Batch_Response_Adapter extends Batch_Response_Adapter
{
    /**
     * @return mixed[][]
     * @throws Operation_Failed
     */
    public function to_array(): array
    {
        try {
            $result = Array_Helper::wrap(json_decode($this->get_response(), true, flags: JSON_THROW_ON_ERROR));

            if(Array_Helper::is_associative($result)){
                $result = [$result];
            }

            return $result;
        } catch (JsonException $e) {
            throw new Operation_Failed('Response is malformed', previous: $e);
        }
    }
}