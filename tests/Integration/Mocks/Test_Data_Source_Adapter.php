<?php

namespace Adiungo\Core\Tests\Integration\Mocks;


use Adiungo\Core\Factories\Adapters\Data_Source_Adapter;
use Underpin\Enums\Types;

class Test_Data_Source_Adapter extends Data_Source_Adapter
{

    public function __construct()
    {
        $this->set_content_model_instance(Test_Model::class)
            ->map_field('content', 'set_content', Types::String)
            ->map_field('name', 'set_name', Types::String)
            ->map_field('id', 'set_id', Types::Integer);
    }
}