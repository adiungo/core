<?php

namespace Adiungo\Core\Tests\Unit\Events;


use Adiungo\Core\Abstracts\Index_Strategy_Builder;
use Adiungo\Core\Events\Providers\Index_Strategy_Provider;
use Adiungo\Core\Events\Queue_Index_Event;
use Adiungo\Core\Factories\Index_Strategy;
use Adiungo\Core\Interfaces\Data_Source;
use Adiungo\Core\Tests\Test_Case;
use Adiungo\Core\Tests\Traits\With_Inaccessible_Methods;
use Mockery;
use ReflectionException;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;

class Queue_Index_Event_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Events\Queue_Index_Event::get_broadcaster_key
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_broadcaster_key(): void
    {
        $instance = new Queue_Index_Event();
        $index_strategy_builder = Mockery::mock(Index_Strategy_Builder::class);
        $data_source = Mockery::namedMock('Foo', Data_Source::class);

        $index_strategy_builder->allows('get_model')->andReturn('Bar');
        $index_strategy_builder->allows('get_index_strategy->get_data_source')->andReturn($data_source);

        $this->assertEquals('Foo__Bar', $this->call_inaccessible_method($instance, 'get_broadcaster_key', $index_strategy_builder));
    }

    /**
     * @covers \Adiungo\Core\Events\Queue_Index_Event::attach
     *
     * @return void
     * @throws Unknown_Registry_Item
     * @throws Operation_Failed
     */
    public function test_can_attach(): void
    {
        $instance = Mockery::mock(Queue_Index_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();
        $index_strategy_builder = Mockery::mock(Index_Strategy_Builder::class);
        $callback = fn() => '';

        $instance->allows('get_broadcaster_key')->with($index_strategy_builder)->andReturn('foo');
        $instance->expects('get_broadcaster->attach')->with('foo', $callback);

        $instance->attach($index_strategy_builder, $callback);
    }

    /**
     * @covers \Adiungo\Core\Events\Queue_Index_Event::detach
     *
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_detach(): void
    {
        $instance = Mockery::mock(Queue_Index_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();
        $index_strategy_builder = Mockery::mock(Index_Strategy_Builder::class);
        $callback = fn() => '';

        $instance->allows('get_broadcaster_key')->with($index_strategy_builder)->andReturn('foo');
        $instance->expects('get_broadcaster->detach')->with('foo', $callback);

        $instance->detach($index_strategy_builder, $callback);
    }

    /**
     * @covers \Adiungo\Core\Events\Queue_Index_Event::broadcast
     *
     * @return void
     */
    public function test_can_broadcast(): void
    {
        $instance = Mockery::mock(Queue_Index_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();

        $strategy = Mockery::mock(Index_Strategy::class);

        $index_strategy_builder = Mockery::mock(Index_Strategy_Builder::class);
        $index_strategy_builder->allows('get_index_strategy')->andReturn($strategy);

        $instance->allows('get_broadcaster_key')->with($index_strategy_builder)->andReturn('foo');

        $instance->expects('get_broadcaster->broadcast')->withArgs(function ($key, $strategy_test) use ($strategy) {
            return $key === 'foo' && $strategy_test instanceof Index_Strategy_Provider && $strategy_test->get_index_strategy() === $strategy;
        });


        $instance->broadcast($index_strategy_builder);
    }

}