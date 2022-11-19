<?php

namespace Adiungo\Core\Tests\Unit\Factories;


use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Factories\Index_Strategy;
use Adiungo\Core\Tests\Test_Case;
use Adiungo\Core\Tests\Traits\With_Inaccessible_Methods;
use Mockery;
use ReflectionException;

class Index_Strategy_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Factories\Index_Strategy::index_data
     *
     * @return void
     */
    public function test_can_index_data(): void
    {
        $mock = Mockery::mock(Index_Strategy::class)->makePartial();

        $mock->expects('get_data_source->get_data->each')->once()->with([$mock, 'save_item']);

        $mock->index_data();
    }

    /**
     * @covers \Adiungo\Core\Factories\Index_Strategy::save_item
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_save_item(): void
    {
        $mock = Mockery::mock(Index_Strategy::class)->makePartial();
        $model = Mockery::mock(Content_Model::class);

        $model->expects('save')->once();

        $this->call_inaccessible_method($mock, 'save_item', $model);
    }

    /**
     * @covers \Adiungo\Core\Factories\Index_Strategy::index_item
     *
     * @return void
     */
    public function test_can_index_item(): void
    {
        $id = 123;
        $mock = Mockery::mock(Index_Strategy::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $model = Mockery::mock(Content_Model::class);

        $mock->expects('get_data_source->get_item')->with($id)->once()->andReturn($model);
        $mock->expects('save_item')->with($model);

        $mock->index_item($id);
    }
}