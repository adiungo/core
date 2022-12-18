<?php

namespace Adiungo\Core\Tests\Integration\Mocks;

use Adiungo\Core\Abstracts\Batch_Response_Adapter;
use Underpin\Helpers\Array_Helper;

class Batch_Response_Adapter_Mock extends Batch_Response_Adapter
{
    /**
     * @return object[]
     */
    public function to_array(): array
    {
        $response = Array_Helper::wrap(json_decode($this->get_response(), true));

        return $response['items'] ?? [];
    }
}
