<?php

namespace Adiungo\Core\Tests\Integration\Mocks;

use Adiungo\Core\Collections\Category_Collection;
use Adiungo\Core\Factories\Adapters\Data_Source_Adapter;
use Adiungo\Core\Factories\Category;
use Underpin\Enums\Types;
use Underpin\Helpers\Array_Helper;

class Test_Data_Source_Adapter extends Data_Source_Adapter
{
    public function __construct()
    {
        $this->set_content_model_instance(Test_Model::class)
            ->map_field('content', 'set_content', Types::String)
            ->map_field('name', 'set_name', Types::String)
            ->map_field(
                'categories', 'add_categories',
                fn(array $categories) => Array_Helper::map($categories, fn(int $category) => (new Category())->set_id($category))
            )
            ->map_field('id', 'set_id', Types::Integer);
    }
}
