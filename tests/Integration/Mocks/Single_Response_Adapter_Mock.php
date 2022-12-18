<?php

namespace Adiungo\Core\Tests\Integration\Mocks;


use Adiungo\Core\Abstracts\Single_Response_Adapter;

class Single_Response_Adapter_Mock extends Single_Response_Adapter
{
    /**
     * @return mixed[]
     */
    public function to_array(): array
    {
        return (array)json_decode($this->get_response(), true);
    }
}