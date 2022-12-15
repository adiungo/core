<?php

namespace Adiungo\Core\Tests\Integration;

use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Factories\Adapters\Data_Source_Adapter;
use Adiungo\Core\Factories\Data_Sources\CSV;
use Adiungo\Core\Tests\Integration\Mocks\Test_Data_Source_Adapter;
use Adiungo\Core\Tests\Integration\Mocks\Test_Model;
use Adiungo\Tests\Test_Case;
use Underpin\Enums\Types;
use Underpin\Exceptions\Item_Not_Found;
use Underpin\Exceptions\Operation_Failed;

class CSV_Data_Source_Test extends Test_Case
{
    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::get_item
     * @throws Operation_Failed
     * @throws Item_Not_Found
     */
    public function test_can_get_item(): void
    {
        $item = (new CSV())
            ->set_data_source_adapter(new Test_Data_Source_Adapter())
            ->set_csv("id,content,name\r1,\"the content\",alex\r2,\"more content\",stephen")
            ->get_item(2);

        $expected = (new Test_Model())
            ->set_id(2)
            ->set_name('stephen')
            ->set_content('more content');

        $this->assertEquals($expected, $item);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::get_data
     *
     * @throws Operation_Failed
     */
    public function test_can_get_data(): void
    {
        $adapter = (new Data_Source_Adapter())
            ->set_content_model_instance(Test_Model::class)
            ->map_field('content', 'set_content', Types::String)
            ->map_field('name', 'set_name', Types::String)
            ->map_field('id', 'set_id', Types::Integer);

        $item = (new CSV())
            ->set_data_source_adapter($adapter)
            ->set_offset(2)
            ->set_limit(2)
            ->set_csv("id,content,name\r1,\"the content\",alex\r2,\"more content\",stephen\r3,\"another content\",kate\r4,\"even more content\",kara")
            ->get_data();

        $expected = (new Content_Model_Collection())->seed([
            (new Test_Model())
                ->set_id(2)
                ->set_name('stephen')
                ->set_content('more content'),
            (new Test_Model())
                ->set_id(3)
                ->set_name('kate')
                ->set_content('another content'),
        ]);

        $this->assertEquals($expected, $item);
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::get_next
     * @throws Operation_Failed
     */
    public function test_can_get_next(): void
    {
        $adapter = (new Data_Source_Adapter())
            ->set_content_model_instance(Test_Model::class)
            ->map_field('content', 'set_content', Types::String)
            ->map_field('name', 'set_name', Types::String)
            ->map_field('id', 'set_id', Types::Integer);

        $item = (new CSV())
            ->set_data_source_adapter($adapter)
            ->set_offset(1)
            ->set_limit(2)
            ->set_csv("id,content,name\r1,\"the content\",alex\r2,\"more content\",stephen\r3,\"another content\",kate\r4,\"even more content\",kara")
            ->get_next()
            ->get_data();

        $expected = (new Content_Model_Collection())->seed([
            (new Test_Model())
                ->set_id(3)
                ->set_name('kate')
                ->set_content('another content'),
            (new Test_Model())
                ->set_id(4)
                ->set_name('kara')
                ->set_content('even more content'),
        ]);

        $this->assertEquals(array_values($expected->to_array()), array_values($item->to_array()));
    }

    /**
     * @covers \Adiungo\Core\Factories\Data_Sources\CSV::has_more
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_loop(): void
    {
        $adapter = (new Data_Source_Adapter())
            ->set_content_model_instance(Test_Model::class)
            ->map_field('content', 'set_content', Types::String)
            ->map_field('name', 'set_name', Types::String)
            ->map_field('id', 'set_id', Types::Integer);

        $item = (new CSV())
            ->set_data_source_adapter($adapter)
            ->set_offset(1)
            ->set_limit(1)
            ->set_csv("id,content,name\r1,\"the content\",alex\r2,\"more content\",stephen\r3,\"another content\",kate\r4,\"even more content\",kara");

        $result = array_values($item->get_data()->each(fn(Test_Model $model) => $model->get_id()));

        while ($item->has_more()) {
            $item = $item->get_next();
            $result = array_values(array_merge($result, $item->get_data()->each(fn(Test_Model $model) => $model->get_id())));
        }

        $this->assertSame($result, [1, 2, 3, 4]);
    }
}
