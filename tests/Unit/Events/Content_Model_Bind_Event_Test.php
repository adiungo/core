<?php

namespace Adiungo\Core\Tests\Unit\Events;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Events\Content_Model_Bind_Event;
use Adiungo\Core\Events\Content_Model_Event;
use Adiungo\Core\Events\Providers\Content_Model_Binding_Provider;
use Adiungo\Core\Events\Providers\Content_Model_Provider;
use Adiungo\Tests\Test_Case;
use Adiungo\Tests\Traits\With_Inaccessible_Methods;
use Mockery;
use ReflectionException;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;

class Content_Model_Bind_Event_Test extends Test_Case
{
    use With_Inaccessible_Methods;

    /**
     * @covers \Adiungo\Core\Events\Content_Model_Bind_Event::get_broadcaster_key
     *
     * @return void
     * @throws ReflectionException
     */
    public function test_can_get_broadcaster_key(): void
    {
        $instance = new Content_Model_Bind_Event();

        $this->assertEquals('Model_B_Model_C__save', $this->call_inaccessible_method($instance, 'get_broadcaster_key', 'Model_C', 'Model_B', 'save'));
    }

    /**
     * @covers \Adiungo\Core\Events\Content_Model_Bind_Event::attach
     *
     * @return void
     * @throws Unknown_Registry_Item
     * @throws Operation_Failed
     */
    public function test_can_attach(): void
    {
        $instance = Mockery::mock(Content_Model_Bind_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();
        /** @var Content_Model $model */
        $model = Mockery::namedMock('Model_Custom', Content_Model::class);
        /** @var Content_Model $model_b */
        $model_b = Mockery::namedMock('Model_Custom_B', Content_Model::class);
        $action = 'delete';
        $callback = fn () => '';

        $instance->allows('get_broadcaster_key')->with($model::class, $model_b::class, $action)->andReturn('foo');
        $instance->expects('get_broadcaster->attach')->with('foo', $callback);

        $instance->attach($model::class, $model_b::class, $action, $callback);
    }

    /**
     * @covers \Adiungo\Core\Events\Content_Model_Bind_Event::detach
     *
     * @return void
     * @throws Operation_Failed
     */
    public function test_can_detach(): void
    {
        $instance = Mockery::mock(Content_Model_Bind_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();
        /** @var Content_Model $model */
        $model = Mockery::namedMock('Model_Custom', Content_Model::class);
        /** @var Content_Model $model_b */
        $model_b = Mockery::namedMock('Model_Custom_B', Content_Model::class);
        $action = 'delete';
        $callback = fn () => '';

        $instance->allows('get_broadcaster_key')->with($model::class, $model_b::class, $action)->andReturn('foo');
        $instance->expects('get_broadcaster->detach')->with('foo', $callback);

        $instance->detach($model::class, $model_b::class, $action, $callback);
    }

    /**
     * @covers \Adiungo\Core\Events\Content_Model_Bind_Event::broadcast
     *
     * @return void
     */
    public function test_can_broadcast(): void
    {
        $instance = Mockery::mock(Content_Model_Bind_Event::class);
        $instance->shouldAllowMockingProtectedMethods()->makePartial();

        $model = Mockery::namedMock('Model_A', Content_Model::class);
        $model_b = Mockery::namedMock('Model_B', Content_Model::class);

        $model->allows('get_id')->andReturn(123);
        $model_b->allows('get_id')->andReturn(456);

        $provider = new Content_Model_Binding_Provider($model, $model_b);
        $action = 'delete';

        $instance->allows('get_broadcaster_key')->with('Model_A', 'Model_B', $action)->andReturn('foo');
        $instance->expects('get_broadcaster->broadcast')->with('foo', $provider);

        $instance->broadcast($action, $provider);
    }
}
