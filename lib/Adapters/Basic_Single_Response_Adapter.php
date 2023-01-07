<?php

namespace Adiungo\Core\Adapters;

use Adiungo\Core\Abstracts\Single_Response_Adapter;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Helpers\Array_Helper;

class Basic_Single_Response_Adapter extends Single_Response_Adapter
{
    /**
     * Converts the response to an array of data.
     *
     * @return mixed[]
     * @throws Operation_Failed
     */
    public function to_array(): array
    {
        $response = (new Basic_Batch_Response_Adapter())->set_response($this->get_response())->to_array();

        return empty($response) ? [] : Array_Helper::wrap($response[0]);
    }
}
